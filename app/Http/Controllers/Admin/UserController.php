<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Barbershop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Exibe a lista de usuários.
     */
    public function index()
    {
        // Eager loading para otimizar a busca da barbearia
        $usuarios = User::with('barbershop')->latest()->get();
        return view('admin.users.index', compact('usuarios'));
    }

    /**
     * Exibe o formulário de criação de usuário.
     */
    public function create()
    {
        // Pega todas as barbearias para popular o select no formulário
        $barbearias = Barbershop::where('active', true)->orderBy('name')->get();
        return view('admin.users.create', compact('barbearias'));
    }

    /**
     * Armazena um novo usuário no banco de dados.
     */
    public function store(Request $request)
    {
        // 1. Validação dos dados
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'celular' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'in:admin,barber,client'], // Garante que o tipo seja válido
            'barbershop_id' => ['nullable', 'exists:barbershops,id'], // Garante que a barbearia exista
        ]);

        // 2. Criação do usuário
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'celular' => $request->celular,
            'password' => Hash::make($request->password), // Criptografa a senha
            'user_type' => $request->user_type,
            'barbershop_id' => $request->barbershop_id,
        ]);

        // 3. Redirecionamento
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    // Os métodos show, edit, update e destroy virão depois
}
