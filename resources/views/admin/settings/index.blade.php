@extends('layouts.app')

@section('content')
<div class="min-h-screen dark:bg-preto bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold dark:text-white text-preto mb-2">
                <i class="fas fa-cog mr-3 text-dourado"></i>Configurações da Barbearia
            </h1>
            <p class="dark:text-gray-300 text-gray-600">
                Configure as informações e horários de funcionamento da sua barbearia
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>Por favor, corrija os erros abaixo:
                <ul class="mt-2 ml-4">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Informações Básicas -->
            <div class="dark:bg-gray-800 bg-white rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold dark:text-white text-preto mb-6 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-dourado"></i>Informações Básicas
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Nome da Barbearia *
                        </label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $barbershop->name) }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            E-mail *
                        </label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $barbershop->email) }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Telefone *
                        </label>
                        <input type="text" id="phone" name="phone"
                               value="{{ old('phone', $barbershop->phone) }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            CEP *
                        </label>
                        <input type="text" id="zip_code" name="zip_code"
                               value="{{ old('zip_code', $barbershop->zip_code) }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Endereço *
                        </label>
                        <input type="text" id="address" name="address"
                               value="{{ old('address', $barbershop->address) }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Cidade *
                        </label>
                        <input type="text" id="city" name="city"
                               value="{{ old('city', $barbershop->city) }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Estado *
                        </label>
                        <select id="state" name="state"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                            <option value="">Selecione o estado</option>
                            <option value="AC" {{ old('state', $barbershop->state) == 'AC' ? 'selected' : '' }}>Acre</option>
                            <option value="AL" {{ old('state', $barbershop->state) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                            <option value="AP" {{ old('state', $barbershop->state) == 'AP' ? 'selected' : '' }}>Amapá</option>
                            <option value="AM" {{ old('state', $barbershop->state) == 'AM' ? 'selected' : '' }}>Amazonas</option>
                            <option value="BA" {{ old('state', $barbershop->state) == 'BA' ? 'selected' : '' }}>Bahia</option>
                            <option value="CE" {{ old('state', $barbershop->state) == 'CE' ? 'selected' : '' }}>Ceará</option>
                            <option value="DF" {{ old('state', $barbershop->state) == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                            <option value="ES" {{ old('state', $barbershop->state) == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                            <option value="GO" {{ old('state', $barbershop->state) == 'GO' ? 'selected' : '' }}>Goiás</option>
                            <option value="MA" {{ old('state', $barbershop->state) == 'MA' ? 'selected' : '' }}>Maranhão</option>
                            <option value="MT" {{ old('state', $barbershop->state) == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                            <option value="MS" {{ old('state', $barbershop->state) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                            <option value="MG" {{ old('state', $barbershop->state) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                            <option value="PA" {{ old('state', $barbershop->state) == 'PA' ? 'selected' : '' }}>Pará</option>
                            <option value="PB" {{ old('state', $barbershop->state) == 'PB' ? 'selected' : '' }}>Paraíba</option>
                            <option value="PR" {{ old('state', $barbershop->state) == 'PR' ? 'selected' : '' }}>Paraná</option>
                            <option value="PE" {{ old('state', $barbershop->state) == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                            <option value="PI" {{ old('state', $barbershop->state) == 'PI' ? 'selected' : '' }}>Piauí</option>
                            <option value="RJ" {{ old('state', $barbershop->state) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                            <option value="RN" {{ old('state', $barbershop->state) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                            <option value="RS" {{ old('state', $barbershop->state) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                            <option value="RO" {{ old('state', $barbershop->state) == 'RO' ? 'selected' : '' }}>Rondônia</option>
                            <option value="RR" {{ old('state', $barbershop->state) == 'RR' ? 'selected' : '' }}>Roraima</option>
                            <option value="SC" {{ old('state', $barbershop->state) == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                            <option value="SP" {{ old('state', $barbershop->state) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                            <option value="SE" {{ old('state', $barbershop->state) == 'SE' ? 'selected' : '' }}>Sergipe</option>
                            <option value="TO" {{ old('state', $barbershop->state) == 'TO' ? 'selected' : '' }}>Tocantins</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Descrição
                        </label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent"
                                  placeholder="Descreva sua barbearia...">{{ old('description', $barbershop->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Horários de Funcionamento -->
            <div class="dark:bg-gray-800 bg-white rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold dark:text-white text-preto mb-6 flex items-center">
                    <i class="fas fa-clock mr-3 text-dourado"></i>Horários de Funcionamento
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="start_time" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Horário de Abertura *
                        </label>
                        <input type="time" id="start_time" name="start_time"
                               value="{{ old('start_time', $barbershop->business_hours['start'] ?? '09:00') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Horário de Fechamento *
                        </label>
                        <input type="time" id="end_time" name="end_time"
                               value="{{ old('end_time', $barbershop->business_hours['end'] ?? '18:00') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="lunch_start" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Início do Almoço
                        </label>
                        <input type="time" id="lunch_start" name="lunch_start"
                               value="{{ old('lunch_start', $barbershop->business_hours['lunch_start'] ?? '') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>

                    <div>
                        <label for="lunch_end" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-2">
                            Fim do Almoço
                        </label>
                        <input type="time" id="lunch_end" name="lunch_end"
                               value="{{ old('lunch_end', $barbershop->business_hours['lunch_end'] ?? '') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-dourado focus:border-transparent">
                    </div>
                </div>

                <!-- Dias de Funcionamento -->
                <div>
                    <label class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-4">
                        Dias de Funcionamento *
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                        @php
                            $days = [
                                0 => 'Domingo',
                                1 => 'Segunda',
                                2 => 'Terça',
                                3 => 'Quarta',
                                4 => 'Quinta',
                                5 => 'Sexta',
                                6 => 'Sábado'
                            ];
                            $currentWorkingDays = old('working_days', $barbershop->business_hours['working_days'] ?? [1,2,3,4,5,6]);
                        @endphp

                        @foreach($days as $dayNumber => $dayName)
                            <label class="flex items-center space-x-2 cursor-pointer p-3 rounded-lg border dark:border-gray-600 border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 {{ in_array($dayNumber, $currentWorkingDays) ? 'bg-dourado/10 border-dourado' : '' }}">
                                <input type="checkbox" name="working_days[]" value="{{ $dayNumber }}"
                                       {{ in_array($dayNumber, $currentWorkingDays) ? 'checked' : '' }}
                                       class="text-dourado focus:ring-dourado">
                                <span class="text-sm dark:text-gray-300 text-gray-700">{{ $dayName }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs dark:text-gray-400 text-gray-500 mt-2">
                        Selecione os dias em que a barbearia funciona
                    </p>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>

                <button type="submit"
                        class="px-6 py-3 bg-dourado hover:bg-yellow-600 text-preto font-semibold rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
