<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de Dashboard baseadas no tipo de usuário
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard Cliente
    Route::middleware('user.type:client')->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'clientDashboard'])->name('dashboard');
        Route::get('/appointments', [AppointmentController::class, 'clientAppointments'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

        // Rotas para solicitações do cliente
        Route::post('/appointments/{appointment}/request-cancellation', [AppointmentController::class, 'requestCancellation'])->name('appointments.request-cancellation');
        Route::post('/appointments/{appointment}/request-reschedule', [AppointmentController::class, 'requestReschedule'])->name('appointments.request-reschedule');
    });

    // Dashboard Barbeiro
    Route::middleware('user.type:barber')->prefix('barber')->name('barber.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'barberDashboard'])->name('dashboard');
        Route::get('/appointments', [AppointmentController::class, 'barberAppointments'])->name('appointments.index');
        Route::get('/schedule', [AppointmentController::class, 'barberSchedule'])->name('schedule.index');
        Route::get('/clients', [AppointmentController::class, 'barberClients'])->name('clients.index');
        Route::get('/earnings', [AppointmentController::class, 'barberEarnings'])->name('earnings.index');
        Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
        Route::post('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
        Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
    });

    // Dashboard Admin
    Route::middleware('user.type:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('services', \App\Http\Controllers\ServiceController::class);
        Route::resource('barbers', \App\Http\Controllers\BarberController::class);
        Route::resource('appointments', AppointmentController::class);
        Route::post('/appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
        Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
        Route::resource('barbearias', \App\Http\Controllers\Admin\BarbershopController::class)->names('barbershops');


        Route::resource('users', UserController::class);

        // Rotas para processar solicitações de clientes
        Route::post('/appointments/{appointment}/approve-cancellation', [AppointmentController::class, 'approveCancellation'])->name('appointments.approve-cancellation');
        Route::post('/appointments/{appointment}/deny-cancellation', [AppointmentController::class, 'denyCancellation'])->name('appointments.deny-cancellation');
        Route::post('/appointments/{appointment}/approve-reschedule', [AppointmentController::class, 'approveReschedule'])->name('appointments.approve-reschedule');
        Route::post('/appointments/{appointment}/deny-reschedule', [AppointmentController::class, 'denyReschedule'])->name('appointments.deny-reschedule');

        Route::get('/settings', [\App\Http\Controllers\BarbershopController::class, 'settings'])->name('settings');
        Route::put('/settings', [\App\Http\Controllers\BarbershopController::class, 'updateSettings'])->name('settings.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas API para disponibilidade de agendamentos
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/barber/{barber}/available-dates', [AppointmentController::class, 'getAvailableDates'])->name('api.barber.available-dates');
    Route::get('/barber/{barber}/available-times/{date}', [AppointmentController::class, 'getAvailableTimes'])->name('api.barber.available-times');
});

require __DIR__ . '/auth.php';
