<x-app-layout>
    <div
        class="dark:bg-gradient-to-br dark:from-gray-900 dark:via-slate-900 dark:to-gray-800 bg-gradient-to-br from-slate-100 via-gray-50 to-slate-200 min-h-screen transition-all duration-300">
        <!-- Header integrado ao conteúdo -->
        <div class="pt-8 pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 bg-gradient-to-r from-slate-50 via-gray-50 to-slate-100 border-2 dark:border-amber-400 border-teal-600 px-6 py-4 rounded-2xl shadow-2xl transition-all duration-300">
                    <h2 class="font-bold text-2xl dark:text-amber-400 text-teal-700">
                        <i class="fas fa-cut mr-3"></i>Painel do Barbeiro - ByteBarber
                    </h2>
                    <p class="dark:text-gray-300 text-slate-600 text-sm mt-1">Bem-vindo, {{ Auth::user()->name }}!
                        Gerencie sua agenda e serviços.</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Agendamentos da Semana -->
                <div
                    class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-amber-400 border-teal-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-amber-300 hover:border-emerald-500 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-amber-400 text-teal-700 text-sm font-medium uppercase tracking-wider">
                                Esta Semana</p>
                            <p class="dark:text-white text-slate-800 text-3xl font-bold mt-2">
                                {{ $weeklyStats['total_appointments'] }}</p>
                            <p class="dark:text-gray-400 text-slate-600 text-xs">agendamentos</p>
                        </div>
                        <div
                            class="dark:bg-gradient-to-r dark:from-amber-400 dark:to-yellow-500 bg-gradient-to-r from-teal-600 to-emerald-600 p-3 rounded-full shadow-lg">
                            <i class="fas fa-calendar-week dark:text-gray-900 text-slate-50 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Serviços Concluídos -->
                <div
                    class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-emerald-400 border-emerald-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-emerald-300 hover:border-emerald-700 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-400 text-sm font-medium uppercase tracking-wider">Concluídos</p>
                            <p class="text-white text-3xl font-bold mt-2">{{ $weeklyStats['completed_appointments'] }}
                            </p>
                            <p class="text-gray-400 text-xs">esta semana</p>
                        </div>
                        <div class="bg-gradient-to-r from-emerald-400 to-green-500 p-3 rounded-full shadow-lg">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Receita Semanal -->
                <div
                    class="bg-gradient-to-br from-slate-800 to-gray-900 border-2 border-purple-400 rounded-2xl p-6 hover:shadow-2xl hover:border-purple-300 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-400 text-sm font-medium uppercase tracking-wider">Receita</p>
                            <p class="text-white text-2xl font-bold mt-2">R$
                                {{ number_format($weeklyStats['total_revenue'], 2, ',', '.') }}
                            </p>
                            <p class="text-gray-400 text-xs">esta semana</p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-400 to-violet-500 p-3 rounded-full shadow-lg">
                            <i class="fas fa-dollar-sign text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Agenda de Hoje -->
                <div
                    class="lg:col-span-2 bg-gradient-to-br from-slate-800 to-gray-900 border-2 border-indigo-400 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 border-b border-indigo-400/30">
                        <h3 class="text-white text-lg font-bold">
                            <i class="fas fa-calendar-day mr-2"></i>Agenda de Hoje - {{ now()->format('d/m/Y') }}
                        </h3>
                    </div>

                    <div class="p-6">
                        @if($todayAppointments->count() > 0)
                            <div class="space-y-4">
                                @foreach($todayAppointments as $appointment)
                                    <div class="bg-gradient-to-r from-gray-800 to-slate-700 border-2 rounded-2xl p-4 hover:shadow-xl transition-all duration-300 transform hover:scale-105
                                                                        @if($appointment->status === 'completed') border-emerald-400 shadow-emerald-400/20
                                                                        @elseif($appointment->scheduled_at->isPast() && $appointment->status === 'scheduled') border-red-400 shadow-red-400/20
                                                                        @else border-indigo-400 shadow-indigo-400/20 @endif">

                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="bg-gradient-to-r from-amber-400 to-yellow-500 text-gray-900 font-bold text-lg px-3 py-1 rounded-full">
                                                    {{ $appointment->scheduled_at->format('H:i') }}
                                                </div>
                                                <div>
                                                    <h4 class="text-white font-semibold flex items-center">
                                                        <i
                                                            class="fas fa-user mr-2 text-indigo-400"></i>{{ $appointment->client->name }}
                                                    </h4>
                                                    <p class="text-gray-400 text-sm flex items-center">
                                                        <i
                                                            class="fas fa-scissors mr-2 text-emerald-400"></i>{{ $appointment->service->name }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-purple-400 font-bold flex items-center justify-end">
                                                    <i class="fas fa-dollar-sign mr-1"></i>R$
                                                    {{ number_format($appointment->price, 2, ',', '.') }}
                                                </p>
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                                    @if($appointment->status === 'completed') bg-gradient-to-r from-emerald-500 to-green-500 text-white
                                                                                    @elseif($appointment->status === 'scheduled') bg-gradient-to-r from-blue-500 to-indigo-500 text-white
                                                                                    @elseif($appointment->status === 'cancelled') bg-gradient-to-r from-red-500 to-pink-500 text-white
                                                                                    @else bg-gradient-to-r from-gray-500 to-slate-500 text-white @endif">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($appointment->status === 'scheduled')
                                            <div class="flex space-x-2">
                                                <button
                                                    class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-3 py-1 rounded-xl text-xs font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg">
                                                    <i class="fas fa-check mr-1"></i>Concluir
                                                </button>
                                                <button
                                                    class="bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-gray-900 px-3 py-1 rounded-xl text-xs font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg">
                                                    <i class="fas fa-edit mr-1"></i>Editar
                                                </button>
                                                <button
                                                    class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white px-3 py-1 rounded-xl text-xs font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg">
                                                    <i class="fas fa-times mr-1"></i>Cancelar
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="bg-gradient-to-r from-gray-800 to-slate-700 rounded-2xl p-6 inline-block">
                                    <i class="fas fa-calendar-times text-4xl text-purple-400 mb-4"></i>
                                    <p class="text-gray-300 text-lg font-medium">Nenhum agendamento para hoje</p>
                                    <p class="text-gray-500 text-sm mt-2">Aproveite para descansar ou organizar seus
                                        materiais!</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informações e Ações -->
                <div class="space-y-6">
                    <!-- Status Rápido -->
                    <div
                        class="bg-gradient-to-br from-slate-800 to-gray-900 border-2 border-emerald-400 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
                        <h3 class="text-emerald-400 text-lg font-bold mb-4">
                            <i class="fas fa-info-circle mr-2"></i>Status
                        </h3>
                        <div class="space-y-3">
                            <div
                                class="flex justify-between bg-gradient-to-r from-gray-800 to-slate-700 rounded-xl p-3 border border-emerald-400/30">
                                <span class="text-gray-300">Agendamentos hoje:</span>
                                <span class="text-emerald-400 font-bold">{{ $todayAppointments->count() }}</span>
                            </div>
                            <div
                                class="flex justify-between bg-gradient-to-r from-gray-800 to-slate-700 rounded-xl p-3 border border-amber-400/30">
                                <span class="text-gray-300">Próximo:</span>
                                <span class="text-amber-400 font-bold">
                                    @php
                                        $next = $todayAppointments->where('status', 'scheduled')->where('scheduled_at', '>', now())->first();
                                    @endphp
                                    {{ $next ? $next->scheduled_at->format('H:i') : 'Nenhum' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    <div
                        class="bg-gradient-to-br from-slate-800 to-gray-900 border-2 border-purple-400 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
                        <h3 class="text-purple-400 text-lg font-bold mb-4">
                            <i class="fas fa-lightning-bolt mr-2"></i>Ações Rápidas
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('barber.appointments.index') }}"
                                class="block w-full bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-gray-900 font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-calendar-alt mr-2"></i>Ver Agenda
                            </a>
                            <a href="{{ route('barber.schedule.index') }}"
                                class="block w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-clock mr-2"></i>Horários
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="block w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-user-edit mr-2"></i>Perfil
                            </a>
                        </div>
                    </div>

                    <!-- Dicas do Dia -->
                    <div
                        class="bg-gradient-to-br from-slate-800 to-gray-900 border-2 border-pink-400 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
                        <h3 class="text-pink-400 text-lg font-bold mb-4">
                            <i class="fas fa-lightbulb mr-2"></i>Dica do Dia
                        </h3>
                        <div
                            class="bg-gradient-to-r from-gray-800 to-slate-700 rounded-xl p-4 border border-pink-400/30">
                            <p class="text-gray-300 text-sm">
                                💡 Mantenha sempre seus equipamentos limpos e esterilizados.
                                A higiene é fundamental para a confiança dos clientes!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação Inferiores -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('barber.appointments.index') }}"
                    class="bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-gray-900 font-bold py-3 px-6 rounded-2xl text-center transition-all duration-200 transform hover:scale-105 shadow-xl">
                    <i class="fas fa-calendar-alt mr-2"></i>Agenda Completa
                </a>
                <a href="{{ route('barber.clients.index') }}"
                    class="bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-2xl text-center transition-all duration-200 transform hover:scale-105 shadow-xl">
                    <i class="fas fa-users mr-2"></i>Meus Clientes
                </a>
                <a href="{{ route('barber.earnings.index') }}"
                    class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold py-3 px-6 rounded-2xl text-center transition-all duration-200 transform hover:scale-105 shadow-xl">
                    <i class="fas fa-chart-line mr-2"></i>Ganhos
                </a>
                <a href="{{ route('barber.schedule.index') }}"
                    class="bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-700 hover:to-violet-700 text-white font-bold py-3 px-6 rounded-2xl text-center transition-all duration-200 transform hover:scale-105 shadow-xl">
                    <i class="fas fa-clock mr-2"></i>Configurar Horários
                </a>
            </div>
        </div>
    </div>
</x-app-layout>