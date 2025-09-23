<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Barber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $appointments = Appointment::with(['client', 'barber.user', 'service'])
            ->where('barbershop_id', $user->barbershop_id)
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::where('barbershop_id', Auth::user()->barbershop_id)->get();
        $barbers = Barber::where('barbershop_id', Auth::user()->barbershop_id)->with('user')->get();

        return view('admin.appointments.create', compact('services', 'barbers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'barber_id' => 'required|exists:barbers,id',
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500'
        ]);

        $service = Service::findOrFail($request->service_id);

        $appointment = Appointment::create([
            'client_id' => $request->client_id,
            'barber_id' => $request->barber_id,
            'service_id' => $request->service_id,
            'barbershop_id' => Auth::user()->barbershop_id,
            'scheduled_at' => $request->scheduled_at,
            'price' => $service->price,
            'notes' => $request->notes,
            'status' => 'scheduled'
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Agendamento criado com sucesso!');
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
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->get();

        $appointmentHistory = Appointment::with(['service', 'barber.user'])
            ->where('client_id', $userId)
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('client.appointments', compact('upcomingAppointments', 'appointmentHistory'));
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
}
