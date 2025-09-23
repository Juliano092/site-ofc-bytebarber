<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServicoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de serviço com a sintaxe CORRIGIDA
    Route::get('/admin/servicos', [ServicoController::class, 'index'])->name('admin.servicos.index');
    Route::get('/admin/servicos/criar', [ServicoController::class, 'create'])->name('admin.servicos.create');
    Route::post('/admin/servicos', [ServicoController::class, 'store'])->name('admin.servicos.store');
    Route::get('/admin/servicos/{servico}/editar', [ServicoController::class, 'edit'])->name('admin.servicos.edit');
    Route::put('/admin/servicos/{servico}', [ServicoController::class, 'update'])->name('admin.servicos.update');
    Route::delete('/admin/servicos/{servico}', [ServicoController::class, 'destroy'])->name('admin.servicos.destroy');
});

require __DIR__ . '/auth.php';
