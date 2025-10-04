<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Barber;
use App\Models\User;
use App\Models\Barbershop;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'barber':
                return redirect()->route('barber.dashboard');
            case 'client':
                return redirect()->route('client.dashboard');
            default:
                abort(403, 'Tipo de usuário inválido');
        }
    }

    public function clientDashboard()
    {
        $user = Auth::user();

        $upcomingAppointments = Appointment::where('client_id', $user->id)
            ->where('scheduled_at', '>', now())
            ->with(['barber.user', 'service'])
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $appointmentHistory = Appointment::where('client_id', $user->id)
            ->where('scheduled_at', '<', now())
            ->with(['barber.user', 'service'])
            ->orderBy('scheduled_at', 'desc')
            ->take(10)
            ->get();

        return view('client.dashboard', compact('upcomingAppointments', 'appointmentHistory'));
    }

    public function barberDashboard()
    {
        $user = Auth::user();
        $barber = $user->barber;

        $todayAppointments = Appointment::where('barber_id', $barber->id)
            ->whereDate('scheduled_at', today())
            ->with(['client', 'service'])
            ->orderBy('scheduled_at')
            ->get();

        $weeklyStats = [
            'total_appointments' => Appointment::where('barber_id', $barber->id)
                ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'completed_appointments' => Appointment::where('barber_id', $barber->id)
                ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->where('status', 'completed')
                ->count(),
            'total_revenue' => Appointment::where('barber_id', $barber->id)
                ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->where('status', 'completed')
                ->sum('price')
        ];

        return view('barber.dashboard', compact('todayAppointments', 'weeklyStats'));
    }

    // Em app/Http/Controllers/DashboardController.php

    public function adminDashboard()
    {
        // Este painel agora é para o dono do sistema, então buscamos dados GLOBAIS.
        $estatisticasGerais = [
            'total_clientes' => \App\Models\User::where('user_type', 'client')->count(),
            'total_barbeiros' => \App\Models\Barber::count(),
            'agendamentos_hoje' => \App\Models\Appointment::whereDate('scheduled_at', today())->count(),
            'faturamento_total' => \App\Models\Appointment::where('status', 'completed')->sum('price'),
            'total_servicos' => \App\Models\Service::count(),
            'agendamentos_pendentes' => \App\Models\Appointment::where('status', 'pending')->count(),
            'solicitacoes_cancelamento' => \App\Models\Appointment::where('cancellation_requested', true)->count(),
            'solicitacoes_reagendamento' => \App\Models\Appointment::where('reschedule_requested', true)->count(),
            'total_barbearias' => \App\Models\Barbershop::count(), // Adicionei este como um bônus
        ];

        $ultimosAgendamentos = \App\Models\Appointment::with(['client', 'barber.user', 'service', 'barbershop'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('estatisticasGerais', 'ultimosAgendamentos'));
    }
}
