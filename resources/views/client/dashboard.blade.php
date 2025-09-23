<x-app-layout>
    <div class="dark:bg-gradient-to-br dark:from-gray-900 dark:via-slate-900 dark:to-gray-800 bg-gradient-to-br from-slate-100 via-gray-50 to-slate-200 min-h-screen transition-all duration-300">
        <!-- Header integrado ao conteúdo -->
        <div class="pt-8 pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 bg-gradient-to-r from-slate-50 via-gray-50 to-slate-100 border-2 dark:border-amber-400 border-teal-600 px-6 py-4 rounded-xl shadow-xl transition-all duration-300">
                    <h2 class="font-bold text-2xl dark:text-amber-400 text-teal-700">
                        <i class="fas fa-user mr-3"></i>Minha Área - ByteBarber
                    </h2>
                    <p class="dark:text-gray-300 text-slate-600 text-sm mt-1">Bem-vindo, {{ Auth::user()->name }}! Gerencie seus agendamentos aqui.</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cards de Resumo -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Próximos Agendamentos -->
                <div class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-amber-400 border-teal-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-amber-300 hover:border-emerald-500 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-amber-400 text-teal-700 text-sm font-medium uppercase tracking-wider">Próximos</p>
                            <p class="dark:text-white text-slate-800 text-3xl font-bold mt-2">{{ $upcomingAppointments->count() }}</p>
                        </div>
                        <div class="dark:bg-gradient-to-r dark:from-amber-400 dark:to-yellow-500 bg-gradient-to-r from-teal-600 to-emerald-600 p-3 rounded-full shadow-lg">
                            <i class="fas fa-calendar-plus dark:text-gray-900 text-slate-50 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Histórico -->
                <div class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-indigo-400 border-slate-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-indigo-300 hover:border-slate-700 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-indigo-400 text-slate-700 text-sm font-medium uppercase tracking-wider">Histórico</p>
                            <p class="dark:text-white text-slate-800 text-3xl font-bold mt-2">{{ $appointmentHistory->count() }}</p>
                        </div>
                        <div class="dark:bg-gradient-to-r dark:from-indigo-400 dark:to-blue-500 bg-gradient-to-r from-slate-600 to-slate-700 p-3 rounded-full shadow-lg">
                            <i class="fas fa-history text-slate-50 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Novo Agendamento -->
                <div class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-emerald-400 border-emerald-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-emerald-300 hover:border-emerald-700 transition-all duration-300 transform hover:scale-105">
                    <div class="text-center">
                        <div class="dark:bg-gradient-to-r dark:from-emerald-400 dark:to-green-500 bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-full inline-block mb-3 shadow-lg">
                            <i class="fas fa-plus text-slate-50 text-xl"></i>
                        </div>
                        <a href="{{ route('client.appointments.create') }}"
                            class="block w-full dark:bg-gradient-to-r dark:from-amber-400 dark:to-yellow-500 dark:hover:from-amber-500 dark:hover:to-yellow-600 dark:text-gray-900 bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-slate-50 font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-lg">
                            Novo Agendamento
                        </a>
                    </div>
                </div>
            </div>

            <!-- Seções de Agendamentos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Próximos Agendamentos -->
                <div class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-amber-400 border-teal-600 rounded-2xl overflow-hidden shadow-xl transition-all duration-300">
                    <div class="px-6 py-4 dark:bg-gradient-to-r dark:from-gray-800 dark:to-slate-800 bg-gradient-to-r from-teal-600 to-slate-700 border-b dark:border-amber-400 border-teal-500">
                        <h3 class="dark:text-amber-400 text-slate-50 text-lg font-bold">
                            <i class="fas fa-calendar-check mr-2"></i>Próximos Agendamentos
                        </h3>
                    </div>

                    <div class="p-6">
                        @if($upcomingAppointments->count() > 0)
                            <div class="space-y-4">
                                @foreach($upcomingAppointments as $appointment)
                                    <div class="dark:bg-gradient-to-r dark:from-gray-700 dark:to-slate-700 bg-gradient-to-r from-slate-100 to-gray-200 border dark:border-gray-600 border-slate-300 rounded-xl p-4 dark:hover:border-amber-400 hover:border-emerald-500 hover:shadow-lg transition-all duration-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="dark:text-amber-400 text-teal-700 font-semibold">{{ $appointment->service->name }}</h4>
                                            <span class="dark:text-emerald-400 text-emerald-700 font-bold">R$ {{ number_format($appointment->price, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="dark:text-gray-300 text-slate-600 text-sm space-y-1">
                                            <p><i class="fas fa-cut mr-2 dark:text-amber-400 text-teal-600"></i>{{ $appointment->barber->user->name }}</p>
                                            <p><i class="fas fa-calendar mr-2 dark:text-indigo-400 text-slate-600"></i>{{ $appointment->scheduled_at->format('d/m/Y') }}</p>
                                            <p><i class="fas fa-clock mr-2 dark:text-purple-400 text-emerald-600"></i>{{ $appointment->scheduled_at->format('H:i') }}</p>
                                        </div>
                                        <div class="mt-3 flex space-x-2">
                                            <button class="dark:bg-gradient-to-r dark:from-indigo-500 dark:to-blue-600 dark:hover:from-indigo-600 dark:hover:to-blue-700 bg-gradient-to-r from-teal-600 to-slate-700 hover:from-teal-700 hover:to-slate-800 text-white px-3 py-1 rounded-lg text-xs font-semibold transition-all duration-200 shadow">
                                                Reagendar
                                            </button>
                                            <button class="dark:bg-gradient-to-r dark:from-red-500 dark:to-pink-600 dark:hover:from-red-600 dark:hover:to-pink-700 bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white px-3 py-1 rounded-lg text-xs font-semibold transition-all duration-200 shadow">
                                                Cancelar
                                            </button>
                                        </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl dark:text-gray-500 text-slate-400 mb-4"></i>
                            <p class="dark:text-gray-400 text-slate-600 text-lg">Nenhum agendamento próximo</p>
                            <p class="dark:text-gray-500 text-slate-500 text-sm mb-4">Que tal agendar um novo corte?</p>
                            <a href="{{ route('client.appointments.create') }}"
                                class="inline-block dark:bg-gradient-to-r dark:from-amber-400 dark:to-yellow-500 dark:hover:from-amber-500 dark:hover:to-yellow-600 dark:text-gray-900 bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 shadow-lg">
                                Agendar Agora
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Histórico -->
            <div class="dark:bg-gradient-to-br dark:from-slate-800 dark:to-gray-900 bg-gradient-to-br from-slate-50 to-gray-100 border-2 dark:border-indigo-400 border-slate-600 rounded-2xl overflow-hidden shadow-xl transition-all duration-300">
                <div class="px-6 py-4 dark:bg-gradient-to-r dark:from-gray-800 dark:to-slate-800 bg-gradient-to-r from-slate-600 to-slate-700 border-b dark:border-indigo-400 border-slate-500">
                    <h3 class="dark:text-indigo-400 text-slate-50 text-lg font-bold">
                        <i class="fas fa-history mr-2"></i>Histórico
                    </h3>
                </div>

                <div class="p-6">
                    @if($appointmentHistory->count() > 0)
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            @foreach($appointmentHistory as $appointment)
                                <div class="dark:bg-gradient-to-r dark:from-gray-700 dark:to-slate-700 bg-gradient-to-r from-slate-100 to-gray-200 border dark:border-gray-600 border-slate-300 rounded-xl p-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="dark:text-gray-300 text-slate-700 font-semibold">{{ $appointment->service->name }}</h4>
                                        <span class="dark:text-emerald-400 text-emerald-700 font-bold">R$ {{ number_format($appointment->price, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="dark:text-gray-400 text-slate-600 text-sm space-y-1">
                                        <p><i class="fas fa-cut mr-2 dark:text-indigo-400 text-teal-600"></i>{{ $appointment->barber->user->name }}</p>
                                        <p><i class="fas fa-calendar mr-2 dark:text-purple-400 text-slate-600"></i>{{ $appointment->scheduled_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($appointment->status === 'completed') dark:bg-gradient-to-r dark:from-emerald-500 dark:to-green-600 bg-gradient-to-r from-emerald-600 to-teal-700 text-white
                                                @elseif($appointment->status === 'cancelled') dark:bg-gradient-to-r dark:from-red-500 dark:to-pink-600 bg-gradient-to-r from-slate-500 to-slate-600 text-white
                                                @else dark:bg-gradient-to-r dark:from-gray-500 dark:to-slate-600 bg-gradient-to-r from-slate-600 to-slate-700 text-white @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-history text-4xl dark:text-gray-500 text-slate-400 mb-4"></i>
                            <p class="dark:text-gray-400 text-slate-600 text-lg">Nenhum histórico ainda</p>
                            <p class="dark:text-gray-500 text-slate-500 text-sm">Seus agendamentos anteriores aparecerão aqui</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botões de Navegação -->
        <div class="pb-12 mt-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('client.appointments.create') }}"
                        class="dark:bg-gradient-to-r dark:from-amber-400 dark:to-yellow-500 dark:hover:from-amber-500 dark:hover:to-yellow-600 dark:text-gray-900 bg-gradient-to-r from-emerald-600 to-teal-700 hover:from-emerald-700 hover:to-teal-800 text-white font-bold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg transform hover:scale-105">
                        <i class="fas fa-calendar-plus mr-2"></i>Novo Agendamento
                    </a>
                    <a href="{{ route('client.appointments.index') }}"
                        class="dark:bg-gradient-to-r dark:from-indigo-600 dark:to-blue-700 dark:hover:from-indigo-700 dark:hover:to-blue-800 bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-bold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg transform hover:scale-105">
                        <i class="fas fa-list mr-2"></i>Meus Agendamentos
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="dark:bg-gradient-to-r dark:from-purple-600 dark:to-indigo-700 dark:hover:from-purple-700 dark:hover:to-indigo-800 bg-gradient-to-r from-teal-600 to-emerald-700 hover:from-teal-700 hover:to-emerald-800 text-white font-bold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg transform hover:scale-105">
                        <i class="fas fa-user-edit mr-2"></i>Meu Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
