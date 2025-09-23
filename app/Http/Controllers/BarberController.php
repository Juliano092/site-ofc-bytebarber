<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BarberController extends Controller
{
    public function index()
    {
        $barbers = Barber::where('barbershop_id', Auth::user()->barbershop_id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.barbers.index', compact('barbers'));
    }

    public function create()
    {
        return view('admin.barbers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'specialties' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        // Criar usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('123456'), // Senha padrão
            'user_type' => 'barber',
            'barbershop_id' => Auth::user()->barbershop_id
        ]);

        // Criar barbeiro
        $barber = Barber::create([
            'user_id' => $user->id,
            'barbershop_id' => Auth::user()->barbershop_id,
            'specialties' => $request->specialties,
            'experience_years' => $request->experience_years,
            'commission_rate' => $request->commission_rate ?? 50,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.barbers.index')
            ->with('success', 'Barbeiro criado com sucesso! Senha padrão: 123456');
    }

    public function show(string $id)
    {
        $barber = Barber::with('user')->findOrFail($id);
        return view('admin.barbers.show', compact('barber'));
    }

    public function edit(string $id)
    {
        $barber = Barber::with('user')->findOrFail($id);
        return view('admin.barbers.edit', compact('barber'));
    }

    public function update(Request $request, string $id)
    {
        $barber = Barber::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $barber->user_id,
            'phone' => 'required|string|max:20',
            'specialties' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        // Atualizar usuário
        $barber->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        // Atualizar barbeiro
        $barber->update([
            'specialties' => $request->specialties,
            'experience_years' => $request->experience_years,
            'commission_rate' => $request->commission_rate ?? $barber->commission_rate,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.barbers.index')
            ->with('success', 'Barbeiro atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $barber = Barber::findOrFail($id);
        $barber->user->delete(); // Soft delete do usuário também deletará o barbeiro

        return redirect()->route('admin.barbers.index')
            ->with('success', 'Barbeiro excluído com sucesso!');
    }
}
