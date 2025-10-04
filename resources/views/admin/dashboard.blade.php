<x-app-layout>
    <div
        class="dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-br from-gray-100 via-white to-gray-200 min-h-screen transition-all duration-300">
        <div class="pt-8 pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="dark:bg-gradient-to-r dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-r from-white via-gray-50 to-gray-100 border-2 dark:border-yellow-500 border-teal-600 px-6 py-4 rounded-xl shadow-xl transition-all duration-300">
                    <h2 class="font-bold text-2xl dark:text-yellow-400 text-teal-700">
                        <i class="fas fa-tachometer-alt mr-3"></i>Dashboard Administrativo - ByteBarber
                    </h2>
                    <p class="dark:text-white text-gray-600 text-sm mt-1">Bem-vindo ao painel de controle
                        administrativo</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-500 border-emerald-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-yellow-400 hover:border-emerald-500 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p
                                class="dark:text-yellow-400 text-emerald-700 text-sm font-medium uppercase tracking-wider">
                                Clientes</p>
                            <p class="dark:text-white text-gray-800 text-3xl font-bold mt-2">
                                {{ $estatisticasGerais['total_clientes'] }}
                            </p>
                        </div>
                        <div
                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-emerald-600 to-emerald-700 p-3 rounded-full shadow-lg">
                            <i class="fas fa-users dark:text-black text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-teal-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-orange-300 hover:border-teal-700 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-orange-400 text-teal-700 text-sm font-medium uppercase tracking-wider">
                                Barbeiros</p>
                            <p class="dark:text-white text-gray-800 text-3xl font-bold mt-2">
                                {{ $estatisticasGerais['total_barbeiros'] }}
                            </p>
                        </div>
                        <div
                            class="dark:bg-gradient-to-r dark:from-orange-400 dark:to-orange-500 bg-gradient-to-r from-teal-600 to-teal-700 p-3 rounded-full shadow-lg">
                            <i class="fas fa-cut text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-400 border-emerald-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-yellow-300 hover:border-emerald-700 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p
                                class="dark:text-yellow-400 text-emerald-700 text-sm font-medium uppercase tracking-wider">
                                Hoje</p>
                            <p class="dark:text-white text-gray-800 text-3xl font-bold mt-2">
                                {{ $estatisticasGerais['agendamentos_hoje'] }}
                            </p>
                        </div>
                        <div
                            class="dark:bg-gradient-to-r dark:from-yellow-400 dark:to-yellow-500 bg-gradient-to-r from-emerald-600 to-emerald-700 p-3 rounded-full shadow-lg">
                            <i class="fas fa-calendar-day dark:text-black text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-amber-500 border-orange-600 rounded-2xl p-6 hover:shadow-2xl dark:hover:border-amber-400 hover:border-orange-700 transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-amber-500 text-orange-700 text-sm font-medium uppercase tracking-wider">
                                Faturamento Total</p>
                            <p class="dark:text-white text-gray-800 text-2xl font-bold mt-2">R$
                                {{ number_format($estatisticasGerais['faturamento_total'], 2, ',', '.') }}
                            </p>
                        </div>
                        <div
                            class="dark:bg-gradient-to-r dark:from-amber-500 dark:to-amber-600 bg-gradient-to-r from-orange-600 to-orange-700 p-3 rounded-full shadow-lg">
                            <i class="fas fa-dollar-sign dark:text-black text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div
                    class="lg:col-span-2 dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-500 border-teal-600 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
                    <h3 class="dark:text-yellow-400 text-teal-700 text-lg font-bold mb-4">
                        <i class="fas fa-chart-bar mr-2"></i>Resumo Rápido
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="text-center dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border dark:border-yellow-400/30 border-emerald-500/30">
                            <div class="text-3xl font-bold dark:text-yellow-400 text-emerald-600">
                                {{ $estatisticasGerais['total_servicos'] }}
                            </div>
                            <div class="dark:text-white text-gray-600 text-sm">Serviços Disponíveis</div>
                        </div>
                        <div
                            class="text-center dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border dark:border-orange-400/30 border-teal-500/30">
                            <div class="text-3xl font-bold dark:text-orange-400 text-teal-600">
                                {{ $estatisticasGerais['agendamentos_pendentes'] }}
                            </div>
                            <div class="dark:text-white text-gray-600 text-sm">Aguardando Aprovação</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div
                            class="text-center dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-4 border dark:border-red-400/30 border-red-500/30">
                            <div class="text-2xl font-bold dark:text-red-400 text-red-600">
                                {{ $estatisticasGerais['solicitacoes_cancelamento'] }}
                            </div>
                            <div class="dark:text-red-200 text-red-700 text-xs font-medium">
                                <i class="fas fa-times mr-1"></i>Cancelamentos
                            </div>
                        </div>
                        <div
                            class="text-center dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 border dark:border-blue-400/30 border-blue-500/30">
                            <div class="text-2xl font-bold dark:text-blue-400 text-blue-600">
                                {{ $estatisticasGerais['solicitacoes_reagendamento'] }}
                            </div>
                            <div class="dark:text-blue-200 text-blue-700 text-xs font-medium">
                                <i class="fas fa-calendar-alt mr-1"></i>Reagendamentos
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-emerald-600 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300">
                    <h3 class="dark:text-orange-400 text-emerald-700 text-lg font-bold mb-4">
                        <i class="fas fa-lightning-bolt mr-2"></i>Ações Rápidas
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.appointments.index') }}"
                            class="block w-full dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 dark:hover:from-yellow-600 dark:hover:to-yellow-700 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:text-black text-white font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-calendar-alt mr-2"></i>Agendamentos
                        </a>
                        <a href="{{ route('admin.barbers.index') }}"
                            class="block w-full dark:bg-gradient-to-r dark:from-orange-500 dark:to-orange-600 dark:hover:from-orange-600 dark:hover:to-orange-700 bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 dark:text-black text-white font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-user-tie mr-2"></i>Barbeiros
                        </a>
                        <a href="{{ route('admin.services.index') }}"
                            class="block w-full dark:bg-gradient-to-r dark:from-amber-600 dark:to-amber-700 dark:hover:from-amber-700 dark:hover:to-amber-800 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 dark:text-black text-white font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-list mr-2"></i>Serviços
                        </a>
                        <a href="{{ route('admin.settings') }}"
                            class="block w-full dark:bg-gradient-to-r dark:from-purple-600 dark:to-purple-700 dark:hover:from-purple-700 dark:hover:to-purple-800 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 dark:text-white text-white font-semibold py-2 px-4 rounded-xl text-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-cog mr-2"></i>Configurações
                        </a>
                    </div>
                </div>
            </div>

            @if($estatisticasGerais['solicitacoes_cancelamento'] > 0 ||
            $estatisticasGerais['solicitacoes_reagendamento'] > 0)
            <div
                class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-500 border-yellow-600 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300 mb-8">
                <div
                    class="px-6 py-4 dark:bg-gradient-to-r dark:from-yellow-600 dark:to-yellow-700 bg-gradient-to-r from-yellow-600 to-yellow-700 border-b dark:border-yellow-400/30 border-yellow-500/30">
                    <h3 class="dark:text-black text-white text-lg font-bold">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Solicitações Pendentes - Requer Atenção
                    </h3>
                    <p class="dark:text-black/70 text-white/80 text-sm mt-1">
                        Clientes aguardando resposta sobre cancelamentos e reagendamentos
                    </p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($estatisticasGerais['solicitacoes_cancelamento'] > 0)
                        <div
                            class="text-center p-4 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 rounded-xl border border-red-200 dark:border-red-700">
                            <i class="fas fa-times text-3xl text-red-600 dark:text-red-400 mb-2"></i>
                            <h4 class="font-semibold text-red-800 dark:text-red-300">Cancelamentos</h4>
                            <p class="text-2xl font-bold text-red-600 dark:text-red-400">
                                {{ $estatisticasGerais['solicitacoes_cancelamento'] }}
                            </p>
                            <a href="{{ route('admin.appointments.index', ['filter' => 'cancellation_requests']) }}"
                                class="inline-block mt-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm transition-colors">
                                Ver Solicitações
                            </a>
                        </div>
                        @endif

                        @if($estatisticasGerais['solicitacoes_reagendamento'] > 0)
                        <div
                            class="text-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl border border-blue-200 dark:border-blue-700">
                            <i class="fas fa-calendar-alt text-3xl text-blue-600 dark:text-blue-400 mb-2"></i>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">Reagendamentos</h4>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $estatisticasGerais['solicitacoes_reagendamento'] }}
                            </p>
                            <a href="{{ route('admin.appointments.index', ['filter' => 'reschedule_requests']) }}"
                                class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm transition-colors">
                                Ver Solicitações
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div
                class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-amber-500 border-orange-600 rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div
                    class="px-6 py-4 dark:bg-gradient-to-r dark:from-amber-600 dark:to-amber-700 bg-gradient-to-r from-orange-600 to-orange-700 border-b dark:border-amber-400/30 border-orange-500/30">
                    <h3 class="dark:text-black text-white text-lg font-bold">
                        <i class="fas fa-clock mr-2"></i>Agendamentos Recentes
                    </h3>
                </div>

                @if($ultimosAgendamentos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead
                            class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-100 to-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium dark:text-yellow-400 text-emerald-700 uppercase tracking-wider">
                                    Cliente</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium dark:text-orange-400 text-teal-700 uppercase tracking-wider">
                                    Barbeiro</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium dark:text-yellow-400 text-emerald-700 uppercase tracking-wider">
                                    Serviço</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium dark:text-amber-400 text-orange-700 uppercase tracking-wider">
                                    Data/Hora</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium dark:text-orange-400 text-teal-700 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium dark:text-yellow-400 text-emerald-700 uppercase tracking-wider">
                                    Valor</th>
                            </tr>
                        </thead>
                        <tbody
                            class="dark:bg-gradient-to-b dark:from-black dark:to-gray-900 bg-gradient-to-b from-white to-gray-50 divide-y dark:divide-gray-700/50 divide-gray-200">
                            @foreach($ultimosAgendamentos as $appointment)
                            <tr
                                class="dark:hover:bg-gradient-to-r dark:hover:from-gray-800 dark:hover:to-gray-900 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-300 hover:shadow-lg">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white text-gray-800">
                                    <i
                                        class="fas fa-user mr-2 dark:text-yellow-400 text-emerald-600"></i>{{ $appointment->client->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-600">
                                    <i
                                        class="fas fa-cut mr-2 dark:text-orange-400 text-teal-600"></i>{{ $appointment->barber->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-600">
                                    <i
                                        class="fas fa-scissors mr-2 dark:text-yellow-400 text-emerald-600"></i>{{ $appointment->service->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-600">
                                    <i
                                        class="fas fa-calendar mr-2 dark:text-amber-400 text-orange-600"></i>{{ $appointment->scheduled_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($appointment->status === 'completed') bg-gradient-to-r from-emerald-500 to-green-500 text-white
                                                    @elseif($appointment->status === 'scheduled') bg-gradient-to-r from-blue-500 to-indigo-500 text-white
                                                    @elseif($appointment->status === 'pending') bg-gradient-to-r from-yellow-500 to-orange-500 text-white
                                                    @elseif($appointment->status === 'in_progress') bg-gradient-to-r from-purple-500 to-pink-500 text-white
                                                    @elseif($appointment->status === 'cancelled') bg-gradient-to-r from-red-500 to-pink-500 text-white
                                                    @elseif($appointment->status === 'rejected') bg-gradient-to-r from-red-600 to-red-700 text-white
                                                    @else bg-gradient-to-r from-gray-500 to-slate-500 text-white @endif">
                                        {{ $appointment->status_in_portuguese }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm dark:text-yellow-400 text-emerald-700 font-bold">
                                    <i class="fas fa-dollar-sign mr-1"></i>R$
                                    {{ number_format($appointment->price, 2, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-8 text-center">
                    <div
                        class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-100 to-gray-200 rounded-2xl p-6 inline-block">
                        <i class="fas fa-calendar-times text-4xl dark:text-amber-400 text-orange-600 mb-4"></i>
                        <p class="dark:text-white text-gray-700 text-lg font-medium">Nenhum agendamento encontrado</p>
                        <p class="dark:text-gray-400 text-gray-500 text-sm mt-2">Os agendamentos aparecerão aqui quando
                            forem criados</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>