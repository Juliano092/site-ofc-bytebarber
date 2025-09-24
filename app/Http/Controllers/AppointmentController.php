<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Barber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Appointment::with(['client', 'barber.user', 'service'])
            ->where('barbershop_id', $user->barbershop_id);

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por data
        if ($request->filled('date')) {
            $query->whereDate('scheduled_at', $request->date);
        }

        // Filtro por barbeiro
        if ($request->filled('barber_id')) {
            $query->where('barber_id', $request->barber_id);
        }

        // Busca por nome do cliente
        if ($request->filled('search')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filtros especiais para solicitações
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'cancellation_requests':
                    $query->where('cancellation_requested', true);
                    break;
                case 'reschedule_requests':
                    $query->where('reschedule_requested', true);
                    break;
            }
        }

        $appointments = $query->orderBy('scheduled_at', 'desc')->paginate(15);

        // Dados para os filtros
        $barbers = Barber::where('barbershop_id', $user->barbershop_id)
            ->with('user')
            ->get();

        return view('admin.appointments.index', compact('appointments', 'barbers'));
    }

    public function create()
    {
        $user = Auth::user();
        $services = Service::where('barbershop_id', $user->barbershop_id)->get();
        $barbers = Barber::where('barbershop_id', $user->barbershop_id)->with('user')->get();

        if ($user->user_type === 'client') {
            // Cliente não precisa escolher cliente - será sempre ele mesmo
            return view('client.appointments.create', compact('services', 'barbers'));
        } else {
            // Admin e Barbeiro podem escolher o cliente
            $clients = User::where('user_type', 'client')->get();
            return view('admin.appointments.create', compact('services', 'barbers', 'clients'));
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validação diferente baseada no tipo de usuário
        if ($user->user_type === 'client') {
            $request->validate([
                'barber_id' => 'required|exists:barbers,id',
                'service_id' => 'required|exists:services,id',
                'scheduled_at' => 'required|date|after:now',
                'notes' => 'nullable|string|max:500'
            ]);

            $client_id = $user->id; // Cliente só pode agendar para si mesmo
        } else {
            // Admin e Barbeiro podem agendar para qualquer cliente
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'barber_id' => 'required|exists:barbers,id',
                'service_id' => 'required|exists:services,id',
                'scheduled_at' => 'required|date|after:now',
                'notes' => 'nullable|string|max:500'
            ]);

            $client_id = $request->client_id;
        }

        $service = Service::findOrFail($request->service_id);

        // Definir status inicial baseado no tipo de usuário
        $initialStatus = ($user->user_type === 'client') ? 'pending' : 'scheduled';

        $appointment = Appointment::create([
            'client_id' => $client_id,
            'barber_id' => $request->barber_id,
            'service_id' => $request->service_id,
            'barbershop_id' => $user->barbershop_id,
            'scheduled_at' => $request->scheduled_at,
            'price' => $service->price,
            'notes' => $request->notes,
            'status' => $initialStatus
        ]);

        // Redirecionamento baseado no tipo de usuário
        if ($user->user_type === 'client') {
            $message = ($initialStatus === 'pending')
                ? 'Agendamento solicitado com sucesso! Aguarde a aprovação da barbearia.'
                : 'Agendamento criado com sucesso!';

            return redirect()->route('client.appointments.index')
                ->with('success', $message);
        } else {
            return redirect()->route('admin.appointments.index')
                ->with('success', 'Agendamento criado com sucesso!');
        }
    }

    public function show(string $id)
    {
        $appointment = Appointment::with(['client', 'barber.user', 'service'])->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $services = Service::where('barbershop_id', Auth::user()->barbershop_id)->get();
        $barbers = Barber::where('barbershop_id', Auth::user()->barbershop_id)->with('user')->get();

        return view('admin.appointments.edit', compact('appointment', 'services', 'barbers'));
    }

    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:scheduled,in_progress,completed,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        $service = Service::findOrFail($request->service_id);

        $appointment->update([
            'barber_id' => $request->barber_id,
            'service_id' => $request->service_id,
            'scheduled_at' => $request->scheduled_at,
            'price' => $service->price,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }

    public function clientAppointments()
    {
        $userId = Auth::id();

        $upcomingAppointments = Appointment::with(['service', 'barber.user'])
            ->where('client_id', $userId)
            ->where('scheduled_at', '>=', now()->startOfDay())
            ->whereIn('status', ['scheduled', 'in_progress']) // Só mostra agendamentos aprovados
            ->orderBy('scheduled_at')
            ->get();

        // Agendamentos pendentes (aguardando aprovação)
        $pendingAppointments = Appointment::with(['service', 'barber.user'])
            ->where('client_id', $userId)
            ->whereIn('status', ['pending'])
            ->orderBy('scheduled_at')
            ->get();

        $appointmentHistory = Appointment::with(['service', 'barber.user'])
            ->where('client_id', $userId)
            ->where('scheduled_at', '<', now()->startOfDay())
            ->whereIn('status', ['completed', 'cancelled', 'rejected', 'no_show'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('client.appointments', compact('upcomingAppointments', 'pendingAppointments', 'appointmentHistory'));
    }

    public function barberSchedule()
    {
        $barber = Auth::user()->barber;

        if (!$barber) {
            abort(403, 'Acesso negado');
        }

        $todayAppointments = Appointment::with(['client', 'service'])
            ->where('barber_id', $barber->id)
            ->whereDate('scheduled_at', today())
            ->orderBy('scheduled_at')
            ->get();

        $weekAppointments = Appointment::with(['client', 'service'])
            ->where('barber_id', $barber->id)
            ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('scheduled_at')
            ->get();

        return view('barber.schedule', compact('todayAppointments', 'weekAppointments'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:scheduled,in_progress,completed,cancelled'
        ]);

        $barber = Auth::user()->barber;

        // Verificar se o barbeiro tem permissão para atualizar este agendamento
        if ($appointment->barber_id !== $barber->id) {
            abort(403, 'Acesso negado');
        }

        $appointment->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status do agendamento atualizado com sucesso!');
    }

    /**
     * Buscar datas disponíveis para um barbeiro
     */
    public function getAvailableDates(Request $request, $barberId)
    {
        Log::info('API getAvailableDates chamada para barbeiro ID: ' . $barberId);

        $barber = Barber::findOrFail($barberId);
        Log::info('Barbeiro encontrado: ' . $barber->user->name);

        // Buscar configurações da barbearia
        $barbershop = $barber->barbershop;
        if (!$barbershop || !$barbershop->business_hours) {
            return response()->json(['error' => 'Horários de funcionamento não configurados'], 400);
        }

        // Usar dias de funcionamento da barbearia
        $businessHours = $barbershop->business_hours;
        $workingDays = $businessHours['working_days'] ?? [1, 2, 3, 4, 5, 6]; // Segunda a sábado por padrão
        $startDate = now();
        $endDate = now()->addMonths(2); // Permitir agendamento até 2 meses à frente        $availableDates = [];
        $unavailableDates = [];

        // Percorrer todos os dias no período
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dayOfWeek = $currentDate->dayOfWeek;
            $dateString = $currentDate->format('Y-m-d');

            // Verificar se é um dia de trabalho
            if (in_array($dayOfWeek, $workingDays)) {
                // Verificar se não é um feriado (você pode criar uma tabela de feriados)
                $isHoliday = $this->isHoliday($currentDate);

                if (!$isHoliday) {
                    $availableDates[] = $dateString;
                } else {
                    $unavailableDates[] = $dateString;
                }
            } else {
                $unavailableDates[] = $dateString;
            }

            $currentDate->addDay();
        }

        Log::info('Retornando dados: disponíveis=' . count($availableDates) . ', indisponíveis=' . count($unavailableDates));

        return response()->json([
            'available_dates' => $availableDates,
            'unavailable_dates' => $unavailableDates,
            'working_days' => $workingDays
        ]);
    }

    /**
     * Buscar horários disponíveis para um barbeiro em uma data específica
     */
    public function getAvailableTimes(Request $request, $barberId, $date)
    {
        $barber = Barber::findOrFail($barberId);
        $selectedDate = \Carbon\Carbon::parse($date);

        // Buscar configurações da barbearia
        $barbershop = $barber->barbershop;
        if (!$barbershop || !$barbershop->business_hours) {
            return response()->json(['error' => 'Horários de funcionamento não configurados'], 400);
        }

        // Buscar o serviço selecionado se fornecido
        $serviceId = $request->get('service_id');
        $selectedService = null;
        $serviceDuration = 30; // Duração padrão em minutos

        if ($serviceId) {
            $selectedService = Service::find($serviceId);
            if ($selectedService) {
                $serviceDuration = $selectedService->duration;
            }
        }

        Log::info("Buscando horários para barbeiro {$barberId}, data {$date}, serviço {$serviceId}, duração {$serviceDuration}min");

        // Usar horários de funcionamento da barbearia
        $businessHours = $barbershop->business_hours;
        $workingHours = [
            'start' => $businessHours['start'] ?? '09:00',
            'end' => $businessHours['end'] ?? '18:00',
            'lunch_start' => $businessHours['lunch_start'] ?? '12:00',
            'lunch_end' => $businessHours['lunch_end'] ?? '13:00',
            'slot_duration' => 30 // Usar slots de 30min para maior flexibilidade
        ];

        // Gerar todos os horários possíveis (slots de 30min)
        $allTimes = $this->generateTimeSlots($workingHours);

        // Buscar agendamentos já marcados para este barbeiro nesta data (com serviços)
        // Apenas agendamentos aprovados ocupam horários
        $bookedAppointments = Appointment::with('service')
            ->where('barber_id', $barberId)
            ->whereDate('scheduled_at', $date)
            ->whereIn('status', ['scheduled', 'in_progress', 'completed']) // Apenas aprovados ocupam horários
            ->get();

        Log::info("Encontrados " . $bookedAppointments->count() . " agendamentos para este dia");

        // Separar horários disponíveis e ocupados
        $availableTimes = [];
        $occupiedTimes = [];

        foreach ($allTimes as $time) {
            $timeSlot = \Carbon\Carbon::parse($date . ' ' . $time);
            $isSlotAvailable = true;

            // Verificar se não é um horário passado (se for hoje)
            if ($selectedDate->isToday() && $timeSlot->isPast()) {
                $isSlotAvailable = false;
            }

            // Verificar conflitos com agendamentos existentes
            if ($isSlotAvailable) {
                foreach ($bookedAppointments as $appointment) {
                    $appointmentStart = \Carbon\Carbon::parse($appointment->scheduled_at);
                    $appointmentDuration = $appointment->service ? $appointment->service->duration : 60;
                    $appointmentEnd = $appointmentStart->copy()->addMinutes($appointmentDuration);

                    // Verificar se o novo agendamento (com a duração do serviço selecionado)
                    // conflitaria com este agendamento existente
                    $newServiceEnd = $timeSlot->copy()->addMinutes($serviceDuration);

                    // Há conflito se:
                    // 1. O novo agendamento começaria durante um agendamento existente, OU
                    // 2. O novo agendamento terminaria durante um agendamento existente, OU
                    // 3. O novo agendamento envolveria completamente um agendamento existente
                    if (
                        ($timeSlot >= $appointmentStart && $timeSlot < $appointmentEnd) ||
                        ($newServiceEnd > $appointmentStart && $newServiceEnd <= $appointmentEnd) ||
                        ($timeSlot <= $appointmentStart && $newServiceEnd >= $appointmentEnd)
                    ) {
                        $isSlotAvailable = false;
                        // Adicionar o horário de início do agendamento existente aos ocupados
                        $occupiedTime = $appointmentStart->format('H:i');
                        if (!in_array($occupiedTime, $occupiedTimes)) {
                            $occupiedTimes[] = $occupiedTime;
                        }
                        break;
                    }
                }
            }

            if ($isSlotAvailable) {
                $availableTimes[] = $time;
            }
        }

        return response()->json([
            'available_times' => $availableTimes,
            'occupied_times' => $occupiedTimes,
            'working_hours' => $workingHours,
            'service_duration' => $serviceDuration,
            'selected_service' => $selectedService ? [
                'id' => $selectedService->id,
                'name' => $selectedService->name,
                'duration' => $selectedService->duration
            ] : null
        ]);
    }

    /**
     * Gerar slots de horário baseado nas configurações
     */
    private function generateTimeSlots($workingHours)
    {
        $times = [];
        $start = \Carbon\Carbon::createFromTimeString($workingHours['start']);
        $end = \Carbon\Carbon::createFromTimeString($workingHours['end']);
        $lunchStart = \Carbon\Carbon::createFromTimeString($workingHours['lunch_start']);
        $lunchEnd = \Carbon\Carbon::createFromTimeString($workingHours['lunch_end']);
        $duration = $workingHours['slot_duration'];

        $current = $start->copy();

        while ($current < $end) {
            // Pular horário de almoço
            if ($current >= $lunchStart && $current < $lunchEnd) {
                $current->addMinutes($duration);
                continue;
            }

            $times[] = $current->format('H:i');
            $current->addMinutes($duration);
        }

        return $times;
    }

    /**
     * Aprovar agendamento
     */
    public function approve(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verificar se usuário tem permissão (admin ou barbeiro responsável)
        $user = Auth::user();
        if (
            $user->user_type !== 'admin' &&
            ($user->user_type !== 'barber' || $appointment->barber->user_id !== $user->id)
        ) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        $appointment->approve();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Agendamento aprovado com sucesso!']);
        }

        return redirect()->back()->with('success', 'Agendamento aprovado com sucesso!');
    }

    /**
     * Rejeitar agendamento
     */
    public function reject(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verificar se usuário tem permissão (admin ou barbeiro responsável)
        $user = Auth::user();
        if (
            $user->user_type !== 'admin' &&
            ($user->user_type !== 'barber' || $appointment->barber->user_id !== $user->id)
        ) {
            return response()->json(['error' => 'Sem permissão'], 403);
        }

        $appointment->reject();

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Agendamento rejeitado.']);
        }

        return redirect()->back()->with('success', 'Agendamento rejeitado.');
    }

    /**
     * Lista de agendamentos para o barbeiro
     */
    public function barberAppointments(Request $request)
    {
        $user = Auth::user();
        $barber = $user->barber;

        if (!$barber) {
            abort(403, 'Acesso negado. Usuário não é um barbeiro.');
        }

        $query = Appointment::with(['client', 'service'])
            ->where('barber_id', $barber->id);

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por data
        if ($request->filled('date')) {
            $query->whereDate('scheduled_at', $request->date);
        }

        // Busca por nome do cliente
        if ($request->filled('search')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $appointments = $query->orderBy('scheduled_at', 'desc')->paginate(15);

        return view('barber.appointments.index', compact('appointments'));
    }

    /**
     * Verificar se uma data é feriado
     * (Você pode implementar isso com uma tabela de feriados)
     */
    private function isHoliday($date)
    {
        // Por enquanto, alguns feriados fixos como exemplo
        $holidays = [
            '2025-12-25', // Natal
            '2025-01-01', // Ano Novo
            // Adicione mais feriados conforme necessário
        ];

        return in_array($date->format('Y-m-d'), $holidays);
    }

    /**
     * Cliente solicita cancelamento
     */
    public function requestCancellation(Request $request, Appointment $appointment)
    {
        // Verificar se o cliente pode cancelar
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Não autorizado');
        }

        if (!$appointment->canBeModifiedByClient()) {
            return back()->with('error', 'Este agendamento não pode mais ser cancelado. Entre em contato conosco.');
        }

        if ($appointment->hasCancellationRequest()) {
            return back()->with('info', 'Já existe uma solicitação de cancelamento pendente para este agendamento.');
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $appointment->requestCancellation($request->reason);

        return back()->with('success', 'Solicitação de cancelamento enviada! Aguarde a confirmação.');
    }

    /**
     * Cliente solicita reagendamento
     */
    public function requestReschedule(Request $request, Appointment $appointment)
    {
        // Verificar se o cliente pode reagendar
        if ($appointment->client_id !== Auth::id()) {
            abort(403, 'Não autorizado');
        }

        if (!$appointment->canBeModifiedByClient()) {
            return back()->with('error', 'Este agendamento não pode mais ser reagendado. Entre em contato conosco.');
        }

        if ($appointment->hasRescheduleRequest()) {
            return back()->with('info', 'Já existe uma solicitação de reagendamento pendente para este agendamento.');
        }

        $request->validate([
            'new_date' => 'required|date|after:tomorrow',
            'new_time' => 'required',
            'reason' => 'required|string|max:500'
        ]);

        $newDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->new_date . ' ' . $request->new_time);

        // Verificar se o novo horário está disponível
        $conflictingAppointment = Appointment::where('barber_id', $appointment->barber_id)
            ->where('scheduled_at', $newDateTime)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->where('id', '!=', $appointment->id)
            ->first();

        if ($conflictingAppointment) {
            return back()->with('error', 'O horário solicitado não está disponível. Escolha outro horário.');
        }

        $appointment->requestReschedule($newDateTime, $request->reason);

        return back()->with('success', 'Solicitação de reagendamento enviada! Aguarde a confirmação.');
    }

    /**
     * Admin aprova cancelamento
     */
    public function approveCancellation(Request $request, Appointment $appointment)
    {
        if (!$appointment->hasCancellationRequest()) {
            return back()->with('error', 'Não há solicitação de cancelamento para este agendamento.');
        }

        $appointment->approveCancellation($request->admin_notes);

        return back()->with('success', 'Solicitação de cancelamento aprovada.');
    }

    /**
     * Admin nega cancelamento
     */
    public function denyCancellation(Request $request, Appointment $appointment)
    {
        if (!$appointment->hasCancellationRequest()) {
            return back()->with('error', 'Não há solicitação de cancelamento para este agendamento.');
        }

        $appointment->denyCancellation($request->admin_notes);

        return back()->with('success', 'Solicitação de cancelamento negada.');
    }

    /**
     * Admin aprova reagendamento
     */
    public function approveReschedule(Request $request, Appointment $appointment)
    {
        if (!$appointment->hasRescheduleRequest()) {
            return back()->with('error', 'Não há solicitação de reagendamento para este agendamento.');
        }

        // Verificar novamente se o horário está disponível
        $conflictingAppointment = Appointment::where('barber_id', $appointment->barber_id)
            ->where('scheduled_at', $appointment->requested_new_datetime)
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->where('id', '!=', $appointment->id)
            ->first();

        if ($conflictingAppointment) {
            return back()->with('error', 'O horário solicitado não está mais disponível.');
        }

        $appointment->approveReschedule($request->admin_notes);

        return back()->with('success', 'Reagendamento aprovado com sucesso.');
    }

    /**
     * Admin nega reagendamento
     */
    public function denyReschedule(Request $request, Appointment $appointment)
    {
        if (!$appointment->hasRescheduleRequest()) {
            return back()->with('error', 'Não há solicitação de reagendamento para este agendamento.');
        }

        $appointment->denyReschedule($request->admin_notes);

        return back()->with('success', 'Solicitação de reagendamento negada.');
    }
}
