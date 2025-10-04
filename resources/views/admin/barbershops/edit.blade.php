<x-app-layout>
    <div class="p-6 sm:p-8">
        <div class="max-w-4xl mx-auto">
            <div class="dark:bg-gray-800 bg-white rounded-lg shadow-xl p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-teal-700 dark:text-yellow-400 mb-6">
                    <i class="fas fa-edit mr-2"></i>Editar Barbearia: {{ $barbearia->name }}
                </h2>

                {{-- AQUI TINHA UM PEQUENO ERRO, AGORA CORRIGIDO para $barbearia->id --}}
                <form action="{{ route('admin.barbershops.update', $barbearia->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- DADOS PRINCIPAIS --}}
                    <fieldset class="border-2 border-gray-300 dark:border-gray-600 p-4 rounded-lg">
                        <legend class="px-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Dados Principais
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="md:col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $barbearia->name) }}"
                                    class="input-form" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $barbearia->email) }}" class="input-form" required>
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefone</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $barbearia->phone) }}"
                                    class="input-form" required>
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- ENDEREÇO --}}
                    <fieldset class="mt-6 border-2 border-gray-300 dark:border-gray-600 p-4 rounded-lg">
                        <legend class="px-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Endereço</legend>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                            <div class="md:col-span-3">
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Endereço
                                    Completo</label>
                                <input type="text" id="address" name="address"
                                    value="{{ old('address', $barbearia->address) }}" class="input-form" required>
                                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="city"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cidade</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $barbearia->city) }}"
                                    class="input-form" required>
                                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="state"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <input type="text" id="state" name="state" value="{{ old('state', $barbearia->state) }}"
                                    class="input-form" required>
                                @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="zip_code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CEP</label>
                                <input type="text" id="zip_code" name="zip_code"
                                    value="{{ old('zip_code', $barbearia->zip_code) }}" class="input-form" required>
                                @error('zip_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- DETALHES --}}
                    <fieldset class="mt-6 border-2 border-gray-300 dark:border-gray-600 p-4 rounded-lg">
                        <legend class="px-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Detalhes</legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 items-center">

                            <div>
                                @if ($barbearia->logo)
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo
                                    Atual</label>
                                <img src="{{ asset('storage/' . $barbearia->logo) }}" alt="Logo Atual"
                                    class="h-20 w-auto rounded-lg">
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <label for="active"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                <select name="active" id="active" class="input-form">
                                    <option value="1" {{ old('active', $barbearia->active) == 1 ? 'selected' : '' }}>
                                        Ativo</option>
                                    <option value="0" {{ old('active', $barbearia->active) == 0 ? 'selected' : '' }}>
                                        Inativo</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
                                <textarea id="description" name="description" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('description', $barbearia->description) }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- HORÁRIOS DE FUNCIONAMENTO --}}
                    <fieldset class="mt-6 border-2 border-gray-300 dark:border-gray-600 p-4 rounded-lg">
                        <legend class="px-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Horários de
                            Funcionamento</legend>
                        @foreach(['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'] as $dia)
                        @php
                        $diaLower = strtolower($dia);
                        $horarioDia = $barbearia->business_hours[$diaLower] ?? ['status' => 'closed', 'open' => '',
                        'close' => ''];
                        @endphp
                        <div class="grid grid-cols-4 gap-3 items-center mt-4">
                            <label class="font-medium text-gray-900 dark:text-white">{{ $dia }}</label>
                            <select name="business_hours[{{ $diaLower }}][status]" class="input-form text-sm">
                                <option value="open"
                                    {{ old("business_hours.$diaLower.status", $horarioDia['status']) == 'open' ? 'selected' : '' }}>
                                    Aberto</option>
                                <option value="closed"
                                    {{ old("business_hours.$diaLower.status", $horarioDia['status']) == 'closed' ? 'selected' : '' }}>
                                    Fechado</option>
                            </select>
                            <input type="time" name="business_hours[{{ $diaLower }}][open]"
                                value="{{ old("business_hours.$diaLower.open", $horarioDia['open']) }}"
                                class="input-form">
                            <input type="time" name="business_hours[{{ $diaLower }}][close]"
                                value="{{ old("business_hours.$diaLower.close", $horarioDia['close']) }}"
                                class="input-form">
                        </div>
                        @endforeach
                        @error('business_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </fieldset>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Atualizar Barbearia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
    .input-form {
        background-color: #F9FAFB;
        border: 1px solid #D1D5DB;
        color: #111827;
        font-size: .875rem;
        border-radius: .5rem;
        display: block;
        width: 100%;
        padding: .625rem
    }

    .dark .input-form {
        background-color: #374151;
        border-color: #4B5563;
        color: #fff
    }

    .btn-primary {
        color: #fff;
        background-image: linear-gradient(to right, #0d9488, #0f766e);
        padding: .625rem 1.25rem;
        border-radius: .5rem;
        text-align: center
    }
    </style>
</x-app-layout>