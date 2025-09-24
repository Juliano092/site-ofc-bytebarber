<x-app-layout>
    <div
        class="dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-br from-gray-100 via-white to-gray-200 min-h-screen transition-all duration-300">

        <!-- Header -->
        <div class="pt-8 pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gradient-to-r dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-r from-white via-gray-50 to-gray-100 border-2 dark:borde            // Controles de navegação do calendário
            document.getElementById('prev-month').addEventListener('click', function() {
                displayMonth--;
                if (displayMonth < 0) {
                    displayMonth = 11;
                    displayYear--;
                }
                loadAvailabilityData();
            });

            document.getElementById('next-month').addEventListener('click', function() {
                displayMonth++;
                if (displayMonth > 11) {
                    displayMonth = 0;
                    displayYear++;
                }
                loadAvailabilityData();
            });

            // Expor função para ser chamada quando barbeiro for selecionado
            window.loadCalendarData = loadAvailabilityData;
        }teal-600 px-6 py-4 rounded-xl shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold text-2xl dark:text-yellow-400 text-teal-700">
                                <i class="fas fa-calendar-plus mr-3"></i>Novo Agendamento
                            </h2>
                            <p class="dark:text-white text-gray-600 text-sm mt-1">Agende seu próximo corte em 3 passos
                                simples</p>
                        </div>
                        <a href="{{ route('client.appointments.index') }}"
                            class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-8">
                    <!-- Step 1 -->
                    <div class="flex items-center">
                        <div id="step1-indicator"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 dark:bg-yellow-500 bg-emerald-600 dark:text-black text-white">
                            1
                        </div>
                        <span class="ml-2 font-medium dark:text-yellow-400 text-emerald-600">Escolher Barbeiro</span>
                    </div>
                    <div class="w-16 h-0.5 dark:bg-gray-600 bg-gray-300"></div>
                    <!-- Step 2 -->
                    <div class="flex items-center">
                        <div id="step2-indicator"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 dark:bg-gray-600 bg-gray-300 dark:text-gray-400 text-gray-500">
                            2
                        </div>
                        <span class="ml-2 font-medium dark:text-gray-400 text-gray-500">Escolher Serviço</span>
                    </div>
                    <div class="w-16 h-0.5 dark:bg-gray-600 bg-gray-300"></div>
                    <!-- Step 3 -->
                    <div class="flex items-center">
                        <div id="step3-indicator"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 dark:bg-gray-600 bg-gray-300 dark:text-gray-400 text-gray-500">
                            3
                        </div>
                        <span class="ml-2 font-medium dark:text-gray-400 text-gray-500">Data & Horário</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('client.appointments.store') }}" method="POST" id="appointment-form">
                @csrf
                <input type="hidden" name="barber_id" id="selected_barber_id">
                <input type="hidden" name="service_id" id="selected_service_id">
                <input type="hidden" name="scheduled_at" id="selected_datetime">

                <!-- Step 1: Escolher Barbeiro -->
                <div id="step1" class="step-content">
                    <div
                        class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-emerald-600 rounded-2xl shadow-xl">
                        <div
                            class="px-6 py-4 dark:bg-gradient-to-r dark:from-orange-500 dark:to-orange-600 bg-gradient-to-r from-emerald-600 to-emerald-700 border-b dark:border-orange-400/30 border-emerald-500/30">
                            <h3 class="dark:text-black text-white text-lg font-bold">
                                <i class="fas fa-cut mr-2"></i>Escolha seu Barbeiro Favorito
                            </h3>
                            <p class="dark:text-black text-white text-sm opacity-90 mt-1">Selecione o profissional que
                                irá cuidar do seu visual</p>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($barbers as $barber)
                                    <div class="barber-card cursor-pointer" data-barber-id="{{ $barber->id }}"
                                        data-barber-name="{{ $barber->user->name }}">
                                        <div
                                            class="barber-card-inner dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 bg-gradient-to-br from-gray-50 to-gray-100 border-2 dark:border-gray-600 border-gray-300 rounded-2xl p-6 transition-all duration-300 hover:shadow-2xl transform hover:scale-105">
                                            <!-- Avatar do Barbeiro -->
                                            <div class="text-center mb-4">
                                                <div
                                                    class="w-20 h-20 mx-auto rounded-full dark:bg-gradient-to-r dark:from-yellow-500 dark:to-amber-600 bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-user-tie text-2xl dark:text-black text-white"></i>
                                                </div>
                                            </div>

                                            <!-- Nome do Barbeiro -->
                                            <h4 class="text-center font-bold text-lg dark:text-white text-gray-800 mb-2">
                                                {{ $barber->user->name }}
                                            </h4>

                                            <!-- Especialidades -->
                                            <div class="text-center space-y-2">
                                                <div
                                                    class="flex items-center justify-center text-sm dark:text-gray-300 text-gray-600">
                                                    <i class="fas fa-star dark:text-yellow-400 text-orange-500 mr-1"></i>
                                                    <span>Especialista</span>
                                                </div>
                                                <div
                                                    class="flex items-center justify-center text-sm dark:text-gray-300 text-gray-600">
                                                    <i class="fas fa-clock dark:text-orange-400 text-teal-500 mr-1"></i>
                                                    <span>8h às 18h</span>
                                                </div>
                                            </div>

                                            <!-- Indicador de Seleção -->
                                            <div class="barber-selected hidden mt-4 text-center">
                                                <div
                                                    class="inline-flex items-center dark:bg-yellow-500 bg-emerald-500 dark:text-black text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    <i class="fas fa-check mr-2"></i>Selecionado
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Escolher Serviço -->
                <div id="step2" class="step-content hidden">
                    <div
                        class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-400 border-orange-600 rounded-2xl shadow-xl">
                        <div
                            class="px-6 py-4 dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-orange-600 to-orange-700 border-b dark:border-yellow-400/30 border-orange-500/30">
                            <h3 class="dark:text-black text-white text-lg font-bold">
                                <i class="fas fa-scissors mr-2"></i>Escolha seu Serviço
                            </h3>
                            <p class="dark:text-black text-white text-sm opacity-90 mt-1">Selecione o tipo de corte ou
                                serviço desejado</p>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($services as $service)
                                    <div class="service-card cursor-pointer" data-service-id="{{ $service->id }}"
                                        data-service-name="{{ $service->name }}" data-service-price="{{ $service->price }}"
                                        data-service-duration="{{ $service->duration }}">
                                        <div
                                            class="service-card-inner dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 bg-gradient-to-br from-gray-50 to-gray-100 border-2 dark:border-gray-600 border-gray-300 rounded-2xl p-6 transition-all duration-300 hover:shadow-2xl transform hover:scale-105">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="font-bold text-lg dark:text-white text-gray-800 mb-2">
                                                        {{ $service->name }}
                                                    </h4>
                                                    <p class="dark:text-gray-300 text-gray-600 text-sm mb-4">
                                                        {{ $service->description ?? 'Serviço profissional de qualidade' }}
                                                    </p>

                                                    <div class="flex items-center space-x-4 text-sm">
                                                        <div class="flex items-center dark:text-yellow-400 text-orange-600">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            <span>{{ $service->duration }}min</span>
                                                        </div>
                                                        <div
                                                            class="flex items-center dark:text-green-400 text-green-600 font-bold">
                                                            <i class="fas fa-dollar-sign mr-1"></i>
                                                            <span>R$
                                                                {{ number_format($service->price, 2, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="ml-4">
                                                    <div
                                                        class="w-16 h-16 rounded-full dark:bg-gradient-to-r dark:from-amber-500 dark:to-yellow-600 bg-gradient-to-r from-orange-500 to-red-600 flex items-center justify-center shadow-lg">
                                                        <i class="fas fa-scissors text-xl dark:text-black text-white"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Indicador de Seleção -->
                                            <div class="service-selected hidden mt-4 text-center">
                                                <div
                                                    class="inline-flex items-center dark:bg-yellow-500 bg-orange-500 dark:text-black text-white px-3 py-1 rounded-full text-sm font-medium">
                                                    <i class="fas fa-check mr-2"></i>Selecionado
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Data e Horário -->
                <div id="step3" class="step-content hidden">
                    <div
                        class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-amber-500 border-red-600 rounded-2xl shadow-xl">
                        <div
                            class="px-6 py-4 dark:bg-gradient-to-r dark:from-amber-500 dark:to-amber-600 bg-gradient-to-r from-red-600 to-red-700 border-b dark:border-amber-400/30 border-red-500/30">
                            <h3 class="dark:text-black text-white text-lg font-bold">
                                <i class="fas fa-calendar-alt mr-2"></i>Escolha Data e Horário
                            </h3>
                            <p class="dark:text-black text-white text-sm opacity-90 mt-1">Selecione o melhor dia e
                                horário para seu atendimento</p>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Calendário -->
                                <div>
                                    <h4 class="font-bold text-lg dark:text-white text-gray-800 mb-4">
                                        <i class="fas fa-calendar dark:text-amber-400 text-red-600 mr-2"></i>Escolha o
                                        Dia
                                    </h4>
                                    <div
                                        class="dark:bg-gray-800 bg-gray-50 rounded-xl p-4 border dark:border-gray-700 border-gray-200">
                                        <!-- Header do Calendário -->
                                        <div class="flex items-center justify-between mb-4">
                                            <button type="button" id="prev-month"
                                                class="p-2 rounded-lg dark:hover:bg-gray-700 hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-chevron-left dark:text-amber-400 text-orange-600"></i>
                                            </button>
                                            <h5 id="calendar-month-year"
                                                class="font-bold dark:text-white text-gray-800"></h5>
                                            <button type="button" id="next-month"
                                                class="p-2 rounded-lg dark:hover:bg-gray-700 hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-chevron-right dark:text-amber-400 text-orange-600"></i>
                                            </button>
                                        </div>

                                        <!-- Dias da Semana -->
                                        <div class="grid grid-cols-7 gap-1 mb-2">
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Dom</div>
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Seg</div>
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Ter</div>
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Qua</div>
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Qui</div>
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Sex</div>
                                            <div
                                                class="text-center p-2 font-medium text-sm dark:text-gray-400 text-gray-600">
                                                Sáb</div>
                                        </div>

                                        <!-- Dias do Calendário -->
                                        <div id="calendar-days" class="grid grid-cols-7 gap-1">
                                            <!-- Dias serão gerados dinamicamente -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Horários Disponíveis -->
                                <div>
                                    <h4 class="font-bold text-lg dark:text-white text-gray-800 mb-4">
                                        <i class="fas fa-clock dark:text-yellow-400 text-orange-600 mr-2"></i>Horários
                                        Disponíveis
                                    </h4>
                                    <div id="available-times" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                        <div class="col-span-full text-center py-8">
                                            <div class="dark:text-gray-400 text-gray-500">
                                                <i class="fas fa-calendar-day text-3xl mb-3 block"></i>
                                                <p class="font-medium">Primeiro escolha uma data</p>
                                                <p class="text-sm opacity-75">Os horários aparecerão aqui</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumo Final -->
                            <div id="booking-summary"
                                class="hidden mt-8 dark:bg-gray-800 bg-gray-50 rounded-xl p-6 border dark:border-gray-700 border-gray-200">
                                <h4 class="font-bold text-lg dark:text-white text-gray-800 mb-4">
                                    <i class="fas fa-check-circle dark:text-green-400 text-green-600 mr-2"></i>Resumo do
                                    Agendamento
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="dark:text-yellow-400 text-orange-600 font-medium">Barbeiro</div>
                                        <div id="summary-barber" class="dark:text-white text-gray-800 font-bold"></div>
                                    </div>
                                    <div class="text-center">
                                        <div class="dark:text-orange-400 text-red-600 font-medium">Serviço</div>
                                        <div id="summary-service" class="dark:text-white text-gray-800 font-bold"></div>
                                    </div>
                                    <div class="text-center">
                                        <div class="dark:text-amber-400 text-orange-600 font-medium">Data & Hora</div>
                                        <div id="summary-datetime" class="dark:text-white text-gray-800 font-bold">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="dark:text-green-400 text-green-600 font-medium">Total</div>
                                        <div id="summary-price"
                                            class="dark:text-green-400 text-green-600 font-bold text-xl"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-8 pb-12">
                    <button type="button" id="prev-btn"
                        class="hidden dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Voltar
                    </button>

                    <div class="flex space-x-4 ml-auto">
                        <a href="{{ route('client.appointments.index') }}"
                            class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>

                        <button type="button" id="next-btn"
                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 dark:hover:from-yellow-600 dark:hover:to-yellow-700 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:text-black text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg"
                            disabled>
                            <span id="next-btn-text">Escolher Barbeiro</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <button type="submit" id="submit-btn"
                            class="hidden dark:bg-gradient-to-r dark:from-green-500 dark:to-green-600 dark:hover:from-green-600 dark:hover:to-green-700 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-calendar-check mr-2"></i>Confirmar Agendamento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Estado do formulário
        let currentStep = 1;
        let selectedBarber = null;
        let selectedService = null;
        let selectedDate = null;
        let selectedTime = null;

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM carregado, inicializando componentes...');
            initializeStepNavigation();
            initializeBarberSelection();
            initializeServiceSelection();
            initializeCalendar();
            console.log('Componentes inicializados');
        });

        function initializeStepNavigation() {
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            const submitBtn = document.getElementById('submit-btn');

            nextBtn.addEventListener('click', nextStep);
            prevBtn.addEventListener('click', prevStep);
        }

        function initializeBarberSelection() {
            const barberCards = document.querySelectorAll('.barber-card');

            barberCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Remove seleção anterior
                    barberCards.forEach(c => {
                        c.querySelector('.barber-selected').classList.add('hidden');
                        c.querySelector('.barber-card-inner').classList.remove('border-yellow-400', 'dark:border-yellow-400');
                    });

                    // Adiciona seleção atual
                    this.querySelector('.barber-selected').classList.remove('hidden');
                    this.querySelector('.barber-card-inner').classList.add('border-yellow-400', 'dark:border-yellow-400');

                    selectedBarber = {
                        id: this.dataset.barberId,
                        name: this.dataset.barberName
                    };

                    document.getElementById('selected_barber_id').value = selectedBarber.id;
                    document.getElementById('next-btn').disabled = false;
                    document.getElementById('next-btn-text').textContent = 'Próximo: Serviço';

                    // Carregar dados de disponibilidade quando barbeiro for selecionado
                    if (window.loadCalendarData) {
                        window.loadCalendarData();
                    }
                });
            });
        }

        function initializeServiceSelection() {
            const serviceCards = document.querySelectorAll('.service-card');

            serviceCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Remove seleção anterior
                    serviceCards.forEach(c => {
                        c.querySelector('.service-selected').classList.add('hidden');
                        c.querySelector('.service-card-inner').classList.remove('border-yellow-400', 'dark:border-yellow-400');
                    });

                    // Adiciona seleção atual
                    this.querySelector('.service-selected').classList.remove('hidden');
                    this.querySelector('.service-card-inner').classList.add('border-yellow-400', 'dark:border-yellow-400');

                    selectedService = {
                        id: this.dataset.serviceId,
                        name: this.dataset.serviceName,
                        price: this.dataset.servicePrice,
                        duration: this.dataset.serviceDuration
                    };

                    document.getElementById('selected_service_id').value = selectedService.id;
                    document.getElementById('next-btn').disabled = false;
                    document.getElementById('next-btn-text').textContent = 'Próximo: Data & Hora';

                    // Se já tem data selecionada, recarregar horários com o novo serviço
                    if (selectedDate) {
                        console.log('Serviço alterado, recarregando horários para a data selecionada');
                        loadAvailableTimes(selectedDate);
                    }
                });
            });
        }

        function initializeCalendar() {
            const currentDate = new Date();
            let displayMonth = currentDate.getMonth();
            let displayYear = currentDate.getFullYear();
            let availabilityData = null;

            // Buscar dados de disponibilidade do servidor
            async function loadAvailabilityData() {
                if (!selectedBarber) {
                    console.log('Nenhum barbeiro selecionado para carregar disponibilidade');
                    return;
                }

                console.log('Carregando disponibilidade para barbeiro ID:', selectedBarber.id);

                try {
                    const url = `/api/barber/${selectedBarber.id}/available-dates`;
                    console.log('Fazendo requisição para:', url);

                    const response = await fetch(url);
                    console.log('Resposta recebida:', response.status, response.statusText);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    availabilityData = await response.json();
                    console.log('Dados de disponibilidade recebidos:', availabilityData);
                    renderCalendar();
                } catch (error) {
                    console.error('Erro ao carregar disponibilidade:', error);
                    // Fallback para dados estáticos
                    availabilityData = {
                        available_dates: [],
                        unavailable_dates: [],
                        working_days: [1, 2, 3, 4, 5, 6] // Segunda a sábado
                    };
                    console.log('Usando dados de fallback:', availabilityData);
                    renderCalendar();
                }
            }

            function renderCalendar() {
                const monthNames = [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ];

                document.getElementById('calendar-month-year').textContent =
                    `${monthNames[displayMonth]} ${displayYear}`;

                const firstDay = new Date(displayYear, displayMonth, 1);
                const lastDay = new Date(displayYear, displayMonth + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startingDay = firstDay.getDay();

                const calendarDays = document.getElementById('calendar-days');
                calendarDays.innerHTML = '';

                // Células vazias para o início do mês
                for (let i = 0; i < startingDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'p-3';
                    calendarDays.appendChild(emptyDay);
                }

                // Dias do mês
                for (let day = 1; day <= daysInMonth; day++) {
                    const date = new Date(displayYear, displayMonth, day);
                    const dateString = date.toISOString().split('T')[0];
                    const isPastDate = date < new Date().setHours(0, 0, 0, 0);
                    const isToday = date.toDateString() === new Date().toDateString();

                    const dayElement = document.createElement('button');
                    dayElement.type = 'button';
                    dayElement.textContent = day;

                    let baseClasses = 'w-full h-12 rounded-lg font-medium transition-all duration-200 ';

                    // Se não há barbeiro selecionado ou dados de disponibilidade
                    if (!selectedBarber || !availabilityData) {
                        if (isPastDate) {
                            // Dias passados
                            dayElement.className = baseClasses + 'dark:bg-gray-700 bg-gray-200 dark:text-gray-500 text-gray-400 cursor-not-allowed opacity-50';
                            dayElement.disabled = true;
                        } else {
                            // Dias futuros (aguardando seleção de barbeiro)
                            dayElement.className = baseClasses + 'dark:bg-gray-600 bg-gray-100 dark:text-gray-400 text-gray-500 cursor-not-allowed';
                            dayElement.disabled = true;
                            dayElement.title = 'Selecione um barbeiro primeiro';

                            if (isToday) {
                                dayElement.className += ' ring-1 ring-gray-400';
                            }
                        }
                    } else {
                        // Com barbeiro selecionado - usar dados reais
                        const isAvailable = availabilityData.available_dates.includes(dateString);
                        const isUnavailable = availabilityData.unavailable_dates.includes(dateString);

                        if (isPastDate || isUnavailable || !isAvailable) {
                            // Dias indisponíveis
                            dayElement.className = baseClasses + 'dark:bg-gray-700 bg-gray-200 dark:text-gray-500 text-gray-400 cursor-not-allowed opacity-50';
                            dayElement.disabled = true;
                        } else {
                            // Dias disponíveis
                            dayElement.className = baseClasses + 'dark:bg-gray-600 bg-white dark:text-white text-gray-800 border dark:border-gray-500 border-gray-300 hover:border-yellow-400 dark:hover:border-yellow-400 hover:shadow-md cursor-pointer';

                            if (isToday) {
                                dayElement.className += ' ring-2 ring-yellow-400 dark:ring-yellow-400';
                            }

                            dayElement.addEventListener('click', function () {
                                selectDate(date, this);
                            });
                        }
                    }

                    calendarDays.appendChild(dayElement);
                }
            }

            // Controles de navegação do calendário
            document.getElementById('prev-month').addEventListener('click', function () {
                displayMonth--;
                if (displayMonth < 0) {
                    displayMonth = 11;
                    displayYear--;
                }
                if (selectedBarber && availabilityData) {
                    loadAvailabilityData();
                } else {
                    renderCalendar();
                }
            });

            document.getElementById('next-month').addEventListener('click', function () {
                displayMonth++;
                if (displayMonth > 11) {
                    displayMonth = 0;
                    displayYear++;
                }
                if (selectedBarber && availabilityData) {
                    loadAvailabilityData();
                } else {
                    renderCalendar();
                }
            });

            // Renderizar calendário inicial (sem barbeiro selecionado)
            renderCalendar();

            // Expor função para ser chamada quando barbeiro for selecionado
            window.loadCalendarData = loadAvailabilityData;
        }

        // Função auxiliar para calcular horário de término
        function calculateEndTime(startTime, durationMinutes) {
            const [hours, minutes] = startTime.split(':').map(Number);
            const startDate = new Date();
            startDate.setHours(hours, minutes, 0, 0);

            const endDate = new Date(startDate.getTime() + (durationMinutes * 60000));

            return endDate.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        }

        function selectDate(date, element) {
            // Remove seleção anterior
            document.querySelectorAll('#calendar-days button:not([disabled])').forEach(btn => {
                btn.classList.remove('dark:bg-yellow-500', 'bg-yellow-500', 'dark:text-black', 'text-black', 'border-yellow-400', 'dark:border-yellow-400');
                btn.classList.add('dark:bg-gray-600', 'bg-white', 'dark:text-white', 'text-gray-800');
            });

            // Adiciona seleção atual
            element.classList.remove('dark:bg-gray-600', 'bg-white', 'dark:text-white', 'text-gray-800');
            element.classList.add('dark:bg-yellow-500', 'bg-yellow-500', 'dark:text-black', 'text-black', 'border-yellow-400', 'dark:border-yellow-400');

            selectedDate = date;
            loadAvailableTimes(date);
        }

        async function loadAvailableTimes(date) {
            const timesContainer = document.getElementById('available-times');
            timesContainer.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-dourado text-xl"></i><p class="text-gray-500 mt-2">Carregando horários...</p></div>';

            if (!selectedBarber) {
                timesContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Selecione um barbeiro primeiro</p>';
                return;
            }

            try {
                // Construir URL com service_id se disponível
                let url = `/api/barber/${selectedBarber.id}/available-times/${date.toISOString().split('T')[0]}`;
                if (selectedService) {
                    url += `?service_id=${selectedService.id}`;
                }

                console.log('Buscando horários com URL:', url);
                const response = await fetch(url);
                const data = await response.json();
                console.log('Dados recebidos:', data);

                timesContainer.innerHTML = '';

                // Mostrar informação sobre a duração do serviço se disponível
                if (data.selected_service) {
                    const serviceInfo = document.createElement('div');
                    serviceInfo.className = 'mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg';
                    serviceInfo.innerHTML = `
                        <div class="text-sm text-yellow-800 dark:text-yellow-200">
                            <i class="fas fa-clock mr-2"></i>
                            <strong>${data.selected_service.name}</strong> - Duração: ${data.service_duration} minutos
                        </div>
                    `;
                    timesContainer.appendChild(serviceInfo);
                }

                if (data.available_times && data.available_times.length > 0) {
                    data.available_times.forEach(time => {
                        const timeBtn = document.createElement('button');
                        timeBtn.type = 'button';
                        timeBtn.className = 'p-4 text-center rounded-xl border-2 transition-all duration-300 hover:shadow-lg transform hover:scale-105 dark:bg-gray-700 bg-white dark:border-gray-600 border-gray-300 dark:text-white text-gray-800 hover:border-yellow-400 dark:hover:border-yellow-400 font-medium';

                        // Calcular horário de término baseado na duração do serviço
                        const endTime = data.service_duration ?
                            calculateEndTime(time, data.service_duration) : time;

                        timeBtn.innerHTML = `
                            <div class="text-lg font-bold">${time}</div>
                            <div class="text-xs opacity-75">
                                ${data.service_duration ? `até ${endTime}` : 'Disponível'}
                            </div>
                        `;

                        timeBtn.addEventListener('click', function () {
                            selectTime(time, this);
                        });

                        timesContainer.appendChild(timeBtn);
                    });
                }

                // Mostrar horários ocupados se retornados
                if (data.booked_times && data.booked_times.length > 0) {
                    data.booked_times.forEach(time => {
                        const timeBtn = document.createElement('button');
                        timeBtn.type = 'button';
                        timeBtn.disabled = true;
                        timeBtn.className = 'p-4 text-center rounded-xl border-2 dark:bg-gray-800 bg-gray-200 dark:border-gray-700 border-gray-400 dark:text-gray-500 text-gray-500 cursor-not-allowed opacity-50';
                        timeBtn.innerHTML = `
                            <div class="text-lg font-bold">${time}</div>
                            <div class="text-xs">Ocupado</div>
                        `;

                        timesContainer.appendChild(timeBtn);
                    });
                }

                if ((!data.available_times || data.available_times.length === 0) && (!data.booked_times || data.booked_times.length === 0)) {
                    timesContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Nenhum horário disponível para este dia</p>';
                }

            } catch (error) {
                console.error('Erro ao carregar horários:', error);
                // Fallback para horários estáticos em caso de erro
                timesContainer.innerHTML = '';
                const fallbackTimes = ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'];
                const occupiedTimes = ['11:00', '15:00'];
                const availableTimes = fallbackTimes.filter(time => !occupiedTimes.includes(time));

                availableTimes.forEach(time => {
                    const timeBtn = document.createElement('button');
                    timeBtn.type = 'button';
                    timeBtn.className = 'p-4 text-center rounded-xl border-2 transition-all duration-300 hover:shadow-lg transform hover:scale-105 dark:bg-gray-700 bg-white dark:border-gray-600 border-gray-300 dark:text-white text-gray-800 hover:border-yellow-400 dark:hover:border-yellow-400 font-medium';
                    timeBtn.innerHTML = `
                        <div class="text-lg font-bold">${time}</div>
                        <div class="text-xs opacity-75">Disponível (modo offline)</div>
                    `;

                    timeBtn.addEventListener('click', function () {
                        selectTime(time, this);
                    });

                    timesContainer.appendChild(timeBtn);
                });

                occupiedTimes.forEach(time => {
                    const timeBtn = document.createElement('button');
                    timeBtn.type = 'button';
                    timeBtn.disabled = true;
                    timeBtn.className = 'p-4 text-center rounded-xl border-2 dark:bg-gray-800 bg-gray-200 dark:border-gray-700 border-gray-400 dark:text-gray-500 text-gray-500 cursor-not-allowed opacity-50';
                    timeBtn.innerHTML = `
                        <div class="text-lg font-bold">${time}</div>
                        <div class="text-xs">Ocupado</div>
                    `;

                    timesContainer.appendChild(timeBtn);
                });
            }
        }

        function selectTime(time, element) {
            // Remove seleção anterior
            document.querySelectorAll('#available-times button:not([disabled])').forEach(btn => {
                btn.classList.remove('border-yellow-400', 'dark:border-yellow-400', 'dark:bg-yellow-500', 'bg-yellow-500', 'dark:text-black', 'text-black');
                btn.classList.add('dark:bg-gray-700', 'bg-white', 'dark:text-white', 'text-gray-800');
            });

            // Adiciona seleção atual
            element.classList.remove('dark:bg-gray-700', 'bg-white', 'dark:text-white', 'text-gray-800');
            element.classList.add('border-yellow-400', 'dark:border-yellow-400', 'dark:bg-yellow-500', 'bg-yellow-500', 'dark:text-black', 'text-black');

            selectedTime = time;

            // Criar datetime completo
            const datetime = new Date(selectedDate);
            const [hours, minutes] = time.split(':');
            datetime.setHours(parseInt(hours), parseInt(minutes));

            // Usar formato local ao invés de UTC para evitar problemas de timezone
            const year = datetime.getFullYear();
            const month = String(datetime.getMonth() + 1).padStart(2, '0');
            const day = String(datetime.getDate()).padStart(2, '0');
            const hoursStr = String(datetime.getHours()).padStart(2, '0');
            const minutesStr = String(datetime.getMinutes()).padStart(2, '0');
            const localDateTimeString = `${year}-${month}-${day}T${hoursStr}:${minutesStr}`;

            document.getElementById('selected_datetime').value = localDateTimeString;

            // Mostrar resumo
            showBookingSummary();

            document.getElementById('next-btn').disabled = false;
            document.getElementById('next-btn').classList.add('hidden');
            document.getElementById('submit-btn').classList.remove('hidden');
        }

        function showBookingSummary() {
            const summary = document.getElementById('booking-summary');

            document.getElementById('summary-barber').textContent = selectedBarber.name;
            document.getElementById('summary-service').textContent = selectedService.name;
            document.getElementById('summary-datetime').textContent = `${selectedDate.toLocaleDateString('pt-BR')} às ${selectedTime}`;
            document.getElementById('summary-price').textContent = `R$ ${parseFloat(selectedService.price).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`;

            summary.classList.remove('hidden');
        }

        function nextStep() {
            if (currentStep < 3) {
                document.getElementById(`step${currentStep}`).classList.add('hidden');
                currentStep++;
                document.getElementById(`step${currentStep}`).classList.remove('hidden');

                updateStepIndicators();
                updateNavigationButtons();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                document.getElementById(`step${currentStep}`).classList.add('hidden');
                currentStep--;
                document.getElementById(`step${currentStep}`).classList.remove('hidden');

                updateStepIndicators();
                updateNavigationButtons();
            }
        }

        function updateStepIndicators() {
            for (let i = 1; i <= 3; i++) {
                const indicator = document.getElementById(`step${i}-indicator`);
                const stepText = indicator.nextElementSibling;

                if (i <= currentStep) {
                    indicator.className = 'w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 dark:bg-yellow-500 bg-emerald-600 dark:text-black text-white';
                    stepText.className = 'ml-2 font-medium dark:text-yellow-400 text-emerald-600';
                } else {
                    indicator.className = 'w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 dark:bg-gray-600 bg-gray-300 dark:text-gray-400 text-gray-500';
                    stepText.className = 'ml-2 font-medium dark:text-gray-400 text-gray-500';
                }
            }
        }

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const submitBtn = document.getElementById('submit-btn');

            // Botão voltar
            if (currentStep > 1) {
                prevBtn.classList.remove('hidden');
            } else {
                prevBtn.classList.add('hidden');
            }

            // Botões avançar/enviar
            if (currentStep === 3) {
                nextBtn.classList.add('hidden');
                if (selectedDate && selectedTime) {
                    submitBtn.classList.remove('hidden');
                }
            } else {
                nextBtn.classList.remove('hidden');
                submitBtn.classList.add('hidden');

                // Desabilitar até ter seleção
                if (currentStep === 1 && !selectedBarber) {
                    nextBtn.disabled = true;
                    document.getElementById('next-btn-text').textContent = 'Escolher Barbeiro';
                } else if (currentStep === 2 && !selectedService) {
                    nextBtn.disabled = true;
                    document.getElementById('next-btn-text').textContent = 'Escolher Serviço';
                }
            }
        }
    </script>
</x-app-layout>