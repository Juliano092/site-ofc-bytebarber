<?php

namespace App\Http\Controllers;

use App\Models\Barbershop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarbershopController extends Controller
{
    /**
     * Mostrar página de configurações da barbearia
     */
    public function settings()
    {
        $user = Auth::user();
        $barbershop = Barbershop::find($user->barbershop_id);

        if (!$barbershop) {
            return redirect()->route('admin.dashboard')->with('error', 'Barbearia não encontrada.');
        }

        return view('admin.settings.index', compact('barbershop'));
    }

    /**
     * Atualizar configurações da barbearia
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $barbershop = Barbershop::find($user->barbershop_id);

        if (!$barbershop) {
            return redirect()->route('admin.dashboard')->with('error', 'Barbearia não encontrada.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|max:10',
            'description' => 'nullable|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'lunch_start' => 'nullable|string',
            'lunch_end' => 'nullable|string',
            'working_days' => 'required|array',
            'working_days.*' => 'integer|min:0|max:6'
        ]);

        // Atualizar informações básicas
        $barbershop->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'description' => $request->description,
            'business_hours' => [
                'start' => $request->start_time,
                'end' => $request->end_time,
                'lunch_start' => $request->lunch_start,
                'lunch_end' => $request->lunch_end,
                'working_days' => $request->working_days
            ]
        ]);

        return redirect()->route('admin.settings')->with('success', 'Configurações atualizadas com sucesso!');
    }
}
