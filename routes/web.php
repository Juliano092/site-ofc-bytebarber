<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

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
    });

    // Dashboard Barbeiro
    Route::middleware('user.type:barber')->prefix('barber')->name('barber.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'barberDashboard'])->name('dashboard');
        Route::get('/appointments', [AppointmentController::class, 'barberAppointments'])->name('appointments.index');
        Route::get('/schedule', [AppointmentController::class, 'barberSchedule'])->name('schedule.index');
        Route::get('/clients', [AppointmentController::class, 'barberClients'])->name('clients.index');
        Route::get('/earnings', [AppointmentController::class, 'barberEarnings'])->name('earnings.index');
        Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    });

    // Dashboard Admin
    Route::middleware('user.type:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('services', \App\Http\Controllers\ServiceController::class);
        Route::resource('barbers', \App\Http\Controllers\BarberController::class);
        Route::resource('appointments', AppointmentController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
