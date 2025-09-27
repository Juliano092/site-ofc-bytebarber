<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca apenas os clientes com status 'S' (Ativos)
        $clientes = Cliente::where('status', 'S')->orderBy('nome_cliente', 'asc')->get();
        return view('admin.lista_clientes', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cadastro_cliente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'cpf' => 'nullable|string|unique:clientes,cpf|max:14',
            'telefone' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:9',
            'bairro' => 'nullable|string|max:255',
            'nome_barbearia' => 'nullable|string|max:255',
        ]);

        Cliente::create($validatedData);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Geralmente não utilizado em CRUDs de listagem, pode ser deixado em branco.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('admin.editar_cliente', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'cpf' => 'nullable|string|unique:clientes,cpf,' . $cliente->id . '|max:14',
            'telefone' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:9',
            'bairro' => 'nullable|string|max:255',
            'nome_barbearia' => 'nullable|string|max:255',
        ]);

        $cliente->update($validatedData);

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Altera o status para 'N' (Inativo) em vez de deletar
        $cliente->update(['status' => 'N']);
        return redirect()->route('admin.clientes.index')->with('success', 'Cliente desativado com sucesso!');
    }

    // Os métodos inativos(), ativar() e jsonInativos() foram removidos pois não são mais necessários.
}
