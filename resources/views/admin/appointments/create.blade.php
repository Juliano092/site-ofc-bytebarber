<x-app-layout>
    <div
        class="dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-br from-gray-100 via-white to-gray-200 min-h-screen transition-all duration-300">

        <!-- Header -->
        <div class="pt-8 pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="dark:bg-gradient-to-r dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-r from-white via-gray-50 to-gray-100 border-2 dark:border-yellow-500 border-teal-600 px-6 py-4 rounded-xl shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold text-2xl dark:text-yellow-400 text-teal-700">
                                <i class="fas fa-calendar-plus mr-3"></i>Novo Agendamento
                            </h2>
                            <p class="dark:text-white text-gray-600 text-sm mt-1">Criar um novo agendamento no sistema
                            </p>
                        </div>
                        <a href="{{ route('admin.appointments.index') }}"
                            class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-amber-500 border-orange-600 rounded-2xl shadow-xl">

                <div
                    class="px-6 py-4 dark:bg-gradient-to-r dark:from-amber-600 dark:to-amber-700 bg-gradient-to-r from-orange-600 to-orange-700 border-b dark:border-amber-400/30 border-orange-500/30">
                    <h3 class="dark:text-black text-white text-lg font-bold">
                        <i class="fas fa-form mr-2"></i>Dados do Agendamento
                    </h3>
                </div>

                <form action="{{ route('admin.appointments.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cliente -->
                        <div>
                            <label for="client_id" class="block text-sm font-medium dark:text-white text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 dark:text-yellow-400 text-emerald-600"></i>Cliente
                            </label>
                            <select name="client_id" id="client_id" required
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 dark:focus:ring-yellow-400 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
                                <option value="">Selecione um cliente</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }} - {{ $client->email }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Barbeiro -->
                        <div>
                            <label for="barber_id" class="block text-sm font-medium dark:text-white text-gray-700 mb-2">
                                <i class="fas fa-cut mr-2 dark:text-orange-400 text-teal-600"></i>Barbeiro
                            </label>
                            <select name="barber_id" id="barber_id" required
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 dark:focus:ring-orange-400 focus:ring-teal-500 focus:border-transparent transition-all duration-200">
                                <option value="">Selecione um barbeiro</option>
                                @foreach($barbers as $barber)
                                    <option value="{{ $barber->id }}">{{ $barber->user->name }}</option>
                                @endforeach
                            </select>
                            @error('barber_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Serviço -->
                        <div>
                            <label for="service_id"
                                class="block text-sm font-medium dark:text-white text-gray-700 mb-2">
                                <i class="fas fa-scissors mr-2 dark:text-yellow-400 text-emerald-600"></i>Serviço
                            </label>
                            <select name="service_id" id="service_id" required
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 dark:focus:ring-yellow-400 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
                                <option value="">Selecione um serviço</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                        data-duration="{{ $service->duration }}">
                                        {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}
                                        ({{ $service->duration }}min)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data e Hora -->
                        <div>
                            <label for="scheduled_at"
                                class="block text-sm font-medium dark:text-white text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 dark:text-amber-400 text-orange-600"></i>Data e Hora
                            </label>
                            <input type="datetime-local" name="scheduled_at" id="scheduled_at" required
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 dark:focus:ring-amber-400 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                            @error('scheduled_at')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Resumo do Serviço -->
                    <div id="service-summary"
                        class="hidden dark:bg-gray-800 bg-gray-50 rounded-lg p-4 border dark:border-gray-700 border-gray-200">
                        <h4 class="font-medium dark:text-white text-gray-900 mb-2">
                            <i class="fas fa-info-circle mr-2 dark:text-yellow-400 text-emerald-600"></i>Resumo do
                            Serviço
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="dark:text-gray-300 text-gray-600">Serviço:</span>
                                <span id="summary-service"
                                    class="dark:text-white text-gray-900 font-medium ml-2"></span>
                            </div>
                            <div>
                                <span class="dark:text-gray-300 text-gray-600">Duração:</span>
                                <span id="summary-duration"
                                    class="dark:text-white text-gray-900 font-medium ml-2"></span>
                            </div>
                            <div>
                                <span class="dark:text-gray-300 text-gray-600">Valor:</span>
                                <span id="summary-price"
                                    class="dark:text-yellow-400 text-emerald-600 font-bold ml-2"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Observações -->
                    <div>
                        <label for="notes" class="block text-sm font-medium dark:text-white text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-2 dark:text-orange-400 text-teal-600"></i>Observações
                            (Opcional)
                        </label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Observações sobre o agendamento..."
                            class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 dark:focus:ring-orange-400 focus:ring-teal-500 focus:border-transparent transition-all duration-200 resize-none"></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end space-x-4 pt-4 border-t dark:border-gray-700 border-gray-200">
                        <a href="{{ route('admin.appointments.index') }}"
                            class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit"
                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 dark:hover:from-yellow-600 dark:hover:to-yellow-700 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:text-black text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Criar Agendamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const serviceSelect = document.getElementById('service_id');
            const summaryDiv = document.getElementById('service-summary');
            const summaryService = document.getElementById('summary-service');
            const summaryDuration = document.getElementById('summary-duration');
            const summaryPrice = document.getElementById('summary-price');

            serviceSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value) {
                    const serviceName = selectedOption.text.split(' - ')[0];
                    const duration = selectedOption.dataset.duration;
                    const price = selectedOption.dataset.price;

                    summaryService.textContent = serviceName;
                    summaryDuration.textContent = duration + ' minutos';
                    summaryPrice.textContent = 'R$ ' + parseFloat(price).toLocaleString('pt-BR', { minimumFractionDigits: 2 });

                    summaryDiv.classList.remove('hidden');
                } else {
                    summaryDiv.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>