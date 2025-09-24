<x-app-layout>
    <div class="dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-br from-gray-100 via-white to-gray-200 min-h-screen transition-all duration-300">

        <!-- Header -->
        <div class="pt-8 pb-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gradient-to-r dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-r from-white via-gray-50 to-gray-100 border-2 dark:border-yellow-500 border-teal-600 px-6 py-4 rounded-xl shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold text-2xl dark:text-yellow-400 text-teal-700">
                                <i class="fas fa-edit mr-3"></i>Editar Agendamento
                            </h2>
                            <p class="dark:text-white text-gray-600 text-sm mt-1">Modifique as informações do agendamento</p>
                        </div>
                        <a href="{{ route('admin.appointments.index') }}"
                            class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 dark:hover:from-gray-700 dark:hover:to-gray-800 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 dark:text-white text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-emerald-600 rounded-2xl p-6 shadow-xl">

                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Cliente -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-yellow-400 text-emerald-700 text-lg font-bold mb-4">
                            <i class="fas fa-user mr-2"></i>Cliente
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium dark:text-white text-gray-700 mb-2">Nome do Cliente</label>
                                <input type="text" value="{{ $appointment->client->name }}" readonly
                                    class="w-full dark:bg-gray-700 bg-gray-100 border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium dark:text-white text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ $appointment->client->email }}" readonly
                                    class="w-full dark:bg-gray-700 bg-gray-100 border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 cursor-not-allowed">
                            </div>
                        </div>
                    </div>

                    <!-- Barbeiro e Serviço -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                            <h3 class="dark:text-orange-400 text-teal-700 text-lg font-bold mb-4">
                                <i class="fas fa-cut mr-2"></i>Barbeiro
                            </h3>
                            <select name="barber_id" id="barber_id" required
                                class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="">Selecione um barbeiro</option>
                                @foreach($barbers as $barber)
                                    <option value="{{ $barber->id }}" {{ $appointment->barber_id == $barber->id ? 'selected' : '' }}>
                                        {{ $barber->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barber_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                            <h3 class="dark:text-purple-400 text-purple-700 text-lg font-bold mb-4">
                                <i class="fas fa-scissors mr-2"></i>Serviço
                            </h3>
                            <select name="service_id" id="service_id" required
                                class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="">Selecione um serviço</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}"
                                        data-price="{{ $service->price }}"
                                        data-duration="{{ $service->duration }}"
                                        {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }} ({{ $service->duration }}min)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Data e Hora -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-blue-400 text-blue-700 text-lg font-bold mb-4">
                            <i class="fas fa-calendar-alt mr-2"></i>Data e Horário
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium dark:text-white text-gray-700 mb-2">Data</label>
                                <input type="date" name="date" id="date"
                                    value="{{ $appointment->scheduled_at->format('Y-m-d') }}"
                                    min="{{ date('Y-m-d') }}" required
                                    class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                @error('date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium dark:text-white text-gray-700 mb-2">Horário</label>
                                <select name="time" id="time" required
                                    class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="">Selecione um horário</option>
                                    <option value="{{ $appointment->scheduled_at->format('H:i') }}" selected>
                                        {{ $appointment->scheduled_at->format('H:i') }}
                                    </option>
                                </select>
                                @error('time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status e Preço -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                            <h3 class="dark:text-pink-400 text-pink-700 text-lg font-bold mb-4">
                                <i class="fas fa-info-circle mr-2"></i>Status
                            </h3>
                            <select name="status" required
                                class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                @foreach(['pending' => 'Pendente', 'scheduled' => 'Agendado', 'in_progress' => 'Em Andamento', 'completed' => 'Concluído', 'cancelled' => 'Cancelado', 'rejected' => 'Rejeitado'] as $status => $label)
                                    <option value="{{ $status }}" {{ $appointment->status == $status ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                            <h3 class="dark:text-green-400 text-green-700 text-lg font-bold mb-4">
                                <i class="fas fa-dollar-sign mr-2"></i>Preço
                            </h3>
                            <input type="number" name="price" id="price" step="0.01" min="0"
                                value="{{ $appointment->price }}" required
                                class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-amber-400 text-amber-700 text-lg font-bold mb-4">
                            <i class="fas fa-sticky-note mr-2"></i>Observações
                        </h3>
                        <textarea name="notes" rows="4" placeholder="Observações adicionais..."
                            class="w-full dark:bg-gray-700 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-4 py-3 dark:text-white text-gray-900 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ $appointment->notes }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botões -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.appointments.show', $appointment) }}"
                            class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 dark:text-white text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit"
                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 dark:hover:from-yellow-600 dark:hover:to-yellow-700 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:text-black text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-save mr-2"></i>Salvar Alterações
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceSelect = document.getElementById('service_id');
            const priceInput = document.getElementById('price');

            // Atualizar preço quando serviço for alterado
            serviceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    priceInput.value = price;
                }
            });

            // Carregar horários disponíveis quando data ou barbeiro mudarem
            const dateInput = document.getElementById('date');
            const barberSelect = document.getElementById('barber_id');
            const timeSelect = document.getElementById('time');

            function loadAvailableTimes() {
                const date = dateInput.value;
                const barberId = barberSelect.value;
                const serviceId = serviceSelect.value;

                if (date && barberId && serviceId) {
                    fetch(`/api/appointments/available-times?date=${date}&barber_id=${barberId}&service_id=${serviceId}&exclude_appointment={{ $appointment->id }}`)
                        .then(response => response.json())
                        .then(times => {
                            timeSelect.innerHTML = '<option value="">Selecione um horário</option>';

                            // Adicionar horário atual como opção
                            const currentTime = '{{ $appointment->scheduled_at->format("H:i") }}';
                            timeSelect.innerHTML += `<option value="${currentTime}" selected>${currentTime} (atual)</option>`;

                            times.forEach(time => {
                                if (time !== currentTime) {
                                    timeSelect.innerHTML += `<option value="${time}">${time}</option>`;
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Erro ao carregar horários:', error);
                        });
                }
            }

            dateInput.addEventListener('change', loadAvailableTimes);
            barberSelect.addEventListener('change', loadAvailableTimes);
            serviceSelect.addEventListener('change', loadAvailableTimes);
        });
    </script>
</x-app-layout>
