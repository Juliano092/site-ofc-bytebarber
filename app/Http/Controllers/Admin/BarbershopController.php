<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barbershop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importe a classe Storage

class BarbershopController extends Controller
{
    /**
     * Mostra o formulário para criar uma nova barbearia.
     */
    public function create()
    {
        return view('admin.barbershops.create');
    }

    /**
     * Salva a nova barbearia no banco de dados.
     */
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:barbershops,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'business_hours' => 'required|array',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $caminhoLogo = $request->file('logo')->store('logos', 'public');
            $dadosValidados['logo'] = $caminhoLogo;
        }

        $dadosValidados['business_hours'] = json_encode($request->business_hours);
        Barbershop::create($dadosValidados);

        return redirect()->route('admin.barbershops.index')
            ->with('success', 'Barbearia cadastrada com sucesso!');
    }

    /**
     * Mostra a lista de barbearias.
     */
    public function index()
    {
        $barbearias = Barbershop::all();
        return view('admin.barbershops.index', compact('barbearias'));
    }

    /**
     * AQUI ESTÁ A CORREÇÃO PRINCIPAL
     * Mostra o formulário para editar a barbearia.
     */
    public function edit(Barbershop $barbearia) // MUDANÇA DE $barbershop PARA $barbearia
    {
        // A variável passada para a view agora se chama 'barbearia'
        return view('admin.barbershops.edit', compact('barbearia'));
    }

    /**
     * Atualiza os dados da barbearia no banco.
     */
    public function update(Request $request, Barbershop $barbearia)
    {
        $dadosValidados = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:barbershops,email,' . $barbearia->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'business_hours' => 'required|array',
            'active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($barbearia->logo) {
                Storage::disk('public')->delete($barbearia->logo);
            }
            $caminhoLogo = $request->file('logo')->store('logos', 'public');
            $dadosValidados['logo'] = $caminhoLogo;
        }

        $dadosValidados['business_hours'] = json_encode($request->business_hours);
        $barbearia->update($dadosValidados);

        return redirect()->route('admin.barbershops.index')
            ->with('success', 'Barbearia atualizada com sucesso!');
    }

    /**
     * Remove a barbearia do banco de dados.
     */
    public function destroy(Barbershop $barbearia)
    {
        if ($barbearia->logo) {
            Storage::disk('public')->delete($barbearia->logo);
        }
        $barbearia->delete();

        return redirect()->route('admin.barbershops.index')
            ->with('success', 'Barbearia excluída com sucesso!');
    }
}
