<x-app-layout>
    <div class="p-6 sm:p-8">
        <div class="max-w-4xl mx-auto">
            <div class="dark:bg-gray-800 bg-white rounded-lg shadow-xl p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-teal-700 dark:text-yellow-400 mb-6">
                    <i class="fas fa-user-plus mr-2"></i>Cadastrar Novo Usuário
                </h2>

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label for="name" class="label-form">Nome Completo</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="input-form"
                                required>
                            @error('name') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="label-form">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-form"
                                required>
                            @error('email') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="celular" class="label-form">Celular</label>
                            <input type="text" id="celular" name="celular" value="{{ old('celular') }}"
                                class="input-form">
                            @error('celular') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="user_type" class="label-form">Tipo de Usuário (Permissão)</label>
                            <select name="user_type" id="user_type" class="input-form" required>
                                <option value="">Selecione um tipo</option>
                                <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Administrador
                                </option>
                                <option value="barber" {{ old('user_type') == 'barber' ? 'selected' : '' }}>Barbeiro
                                </option>
                                <option value="client" {{ old('user_type') == 'client' ? 'selected' : '' }}>Cliente
                                </option>
                            </select>
                            @error('user_type') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="barbershop_id" class="label-form">Vincular à Barbearia (Opcional)</label>
                            <select name="barbershop_id" id="barbershop_id" class="input-form">
                                <option value="">Nenhuma</option>
                                @foreach ($barbearias as $barbearia)
                                <option value="{{ $barbearia->id }}"
                                    {{ old('barbershop_id') == $barbearia->id ? 'selected' : '' }}>
                                    {{ $barbearia->name }}
                                </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1 dark:text-gray-400">Vincule um usuário do tipo
                                "barbeiro" ou "cliente" a uma barbearia específica.</p>
                            @error('barbershop_id') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="label-form">Senha</label>
                            <input type="password" id="password" name="password" class="input-form" required>
                            @error('password') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="label-form">Confirmar Senha</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="input-form" required>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Salvar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Mova essas classes para seu app.css para não repetir --}}
    <style>
        .label-form {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
        }

        .dark .label-form {
            color: white;
        }

        .error-message {
            color: #EF4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .input-form {
            background-color: #F9FAFB;
            border: 1px solid #D1D5DB;
            color: #111827;
            font-size: 0.875rem;
            border-radius: 0.5rem;
            display: block;
            width: 100%;
            padding: 0.625rem;
        }

        .dark .input-form {
            background-color: #374151;
            border-color: #4B5563;
            color: white;
        }

        .btn-primary {
            color: white;
            background-image: linear-gradient(to right, #0d9488, #0f766e);
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            text-align: center;
        }
    </style>
</x-app-layout>