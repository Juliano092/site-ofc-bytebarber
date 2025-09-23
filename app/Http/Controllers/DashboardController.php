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

    public function adminDashboard()
    {
        $user = Auth::user();
        $barbershop = $user->barbershop;

        $dashboardStats = [
            'total_clients' => User::where('barbershop_id', $barbershop->id)
                ->where('user_type', 'client')
                ->count(),
            'total_barbers' => Barber::where('barbershop_id', $barbershop->id)->count(),
            'total_services' => Service::where('barbershop_id', $barbershop->id)->count(),
            'today_appointments' => Appointment::where('barbershop_id', $barbershop->id)
                ->whereDate('scheduled_at', today())
                ->count(),
            'monthly_revenue' => Appointment::where('barbershop_id', $barbershop->id)
                ->whereMonth('scheduled_at', now()->month)
                ->where('status', 'completed')
                ->sum('price'),
            'pending_appointments' => Appointment::where('barbershop_id', $barbershop->id)
                ->where('status', 'scheduled')
                ->count()
        ];

        $recentAppointments = Appointment::where('barbershop_id', $barbershop->id)
            ->with(['client', 'barber.user', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('dashboardStats', 'recentAppointments'));
    }
}
