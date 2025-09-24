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
                                <i class="fas fa-calendar mr-3"></i>Meus Agendamentos
                            </h2>
                            <p class="dark:text-white text-gray-600 text-sm mt-1">Gerencie seus agendamentos</p>
                        </div>
                        <a href="{{ route('client.appointments.create') }}"
                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 dark:hover:from-yellow-600 dark:hover:to-yellow-700 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:text-black text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Novo Agendamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Próximos Agendamentos -->
            @if($upcomingAppointments->count() > 0)
                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-amber-500 border-orange-600 rounded-2xl overflow-hidden shadow-xl">

                    <div
                        class="px-6 py-4 dark:bg-gradient-to-r dark:from-amber-600 dark:to-amber-700 bg-gradient-to-r from-orange-600 to-orange-700 border-b dark:border-amber-400/30 border-orange-500/30">
                        <h3 class="dark:text-black text-white text-lg font-bold">
                            <i class="fas fa-clock mr-2"></i>Próximos Agendamentos
                        </h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($upcomingAppointments as $appointment)
                                <div
                                    class="dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 bg-gradient-to-br from-gray-50 to-gray-100 border dark:border-yellow-400/30 border-emerald-500/30 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                                    <div class="flex justify-between items-start mb-3">
                                        <div
                                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-full p-2">
                                            <i class="fas fa-scissors dark:text-black text-white text-sm"></i>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                                                                            @if($appointment->status === 'scheduled') bg-gradient-to-r from-blue-500 to-indigo-500 text-white
                                                                            @elseif($appointment->status === 'pending') bg-gradient-to-r from-yellow-500 to-orange-500 text-white
                                                                            @elseif($appointment->status === 'in_progress') bg-gradient-to-r from-purple-500 to-pink-500 text-white
                                                                            @elseif($appointment->status === 'completed') bg-gradient-to-r from-green-500 to-emerald-500 text-white
                                                                            @elseif($appointment->status === 'cancelled') bg-gradient-to-r from-red-500 to-pink-500 text-white
                                                                            @elseif($appointment->status === 'rejected') bg-gradient-to-r from-red-600 to-red-700 text-white
                                                                            @else bg-gradient-to-r from-gray-500 to-slate-500 text-white @endif">
                                            {{ $appointment->status_in_portuguese }}
                                        </span>
                                    </div>

                                    <h4 class="dark:text-white text-gray-800 font-semibold mb-2">
                                        {{ $appointment->service->name }}
                                    </h4>

                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-cut mr-2 dark:text-orange-400 text-teal-600"></i>
                                            {{ $appointment->barber->user->name }}
                                        </div>
                                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-calendar mr-2 dark:text-amber-400 text-orange-600"></i>
                                            {{ $appointment->scheduled_at->format('d/m/Y') }}
                                        </div>
                                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-clock mr-2 dark:text-yellow-400 text-emerald-600"></i>
                                            {{ $appointment->scheduled_at->format('H:i') }}
                                        </div>
                                        <div class="flex items-center dark:text-yellow-400 text-emerald-700 font-bold">
                                            <i class="fas fa-dollar-sign mr-2"></i>
                                            R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                        </div>
                                    </div>

                                    @if($appointment->notes)
                                        <div class="mt-3 pt-3 border-t dark:border-gray-700 border-gray-200">
                                            <p class="text-xs dark:text-gray-400 text-gray-500">
                                                <i class="fas fa-sticky-note mr-1"></i>
                                                {{ $appointment->notes }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Botões de Ação -->
                                    @if($appointment->canBeModifiedByClient())
                                        <div class="mt-3 pt-3 border-t dark:border-gray-700 border-gray-200 flex gap-2">
                                            @if(!$appointment->hasCancellationRequest())
                                                <button onclick="openCancellationModal({{ $appointment->id }})"
                                                    class="flex-1 text-xs py-2 px-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-200 font-medium">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Cancelar
                                                </button>
                                            @endif

                                            @if(!$appointment->hasRescheduleRequest())
                                                <button
                                                    onclick="openRescheduleModal({{ $appointment->id }}, {{ $appointment->barber_id }})"
                                                    class="flex-1 text-xs py-2 px-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 font-medium">
                                                    <i class="fas fa-calendar-alt mr-1"></i>
                                                    Reagendar
                                                </button>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Indicadores de Solicitações Pendentes -->
                                    @if($appointment->hasCancellationRequest())
                                        <div class="mt-3 pt-3 border-t dark:border-gray-700 border-gray-200">
                                            <div
                                                class="bg-gradient-to-r from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 border border-orange-300 dark:border-orange-700 rounded-lg p-2">
                                                <p class="text-xs text-orange-700 dark:text-orange-300 font-medium">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Cancelamento solicitado - Aguardando aprovação
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($appointment->hasRescheduleRequest())
                                        <div class="mt-3 pt-3 border-t dark:border-gray-700 border-gray-200">
                                            <div
                                                class="bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 border border-blue-300 dark:border-blue-700 rounded-lg p-2">
                                                <p class="text-xs text-blue-700 dark:text-blue-300 font-medium">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Reagendamento solicitado para
                                                    {{ $appointment->requested_new_datetime?->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Agendamentos Pendentes (Aguardando Aprovação) -->
            @if($pendingAppointments->count() > 0)
                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-500 border-yellow-600 rounded-2xl overflow-hidden shadow-xl">

                    <div
                        class="px-6 py-4 dark:bg-gradient-to-r dark:from-yellow-600 dark:to-yellow-700 bg-gradient-to-r from-yellow-600 to-yellow-700 border-b dark:border-yellow-400/30 border-yellow-500/30">
                        <h3 class="dark:text-black text-white text-lg font-bold">
                            <i class="fas fa-hourglass-half mr-2"></i>Aguardando Aprovação
                        </h3>
                        <p class="dark:text-black/70 text-white/80 text-sm mt-1">
                            Estes agendamentos estão aguardando confirmação do barbeiro
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($pendingAppointments as $appointment)
                                <div
                                    class="dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 dark:border-yellow-400/50 border-yellow-500/50 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                                    <div class="flex justify-between items-start mb-3">
                                        <div
                                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-full p-2">
                                            <i class="fas fa-scissors dark:text-black text-white text-sm"></i>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 text-white">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $appointment->status_in_portuguese }}
                                        </span>
                                    </div>

                                    <h4 class="dark:text-white text-gray-800 font-semibold mb-2">
                                        {{ $appointment->service->name }}
                                    </h4>

                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-cut mr-2 dark:text-orange-400 text-yellow-600"></i>
                                            {{ $appointment->barber->user->name }}
                                        </div>
                                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-calendar mr-2 dark:text-amber-400 text-yellow-600"></i>
                                            {{ $appointment->scheduled_at->format('d/m/Y') }}
                                        </div>
                                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-clock mr-2 dark:text-yellow-400 text-yellow-600"></i>
                                            {{ $appointment->scheduled_at->format('H:i') }}
                                        </div>
                                        <div class="flex items-center dark:text-yellow-400 text-yellow-700 font-bold">
                                            <i class="fas fa-dollar-sign mr-2"></i>
                                            R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                        </div>
                                    </div>

                                    @if($appointment->notes)
                                        <div class="mt-3 pt-3 border-t dark:border-gray-700 border-yellow-300">
                                            <p class="text-xs dark:text-gray-400 text-gray-600">
                                                <i class="fas fa-sticky-note mr-1"></i>
                                                {{ $appointment->notes }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="mt-3 pt-3 border-t dark:border-gray-700 border-yellow-300">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs dark:text-yellow-400 text-yellow-600 font-medium">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Aguardando confirmação
                                            </span>
                                            <span class="text-xs dark:text-gray-400 text-gray-500">
                                                Solicitado em {{ $appointment->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Histórico de Agendamentos -->
            <div
                class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-emerald-600 rounded-2xl overflow-hidden shadow-xl">

                <div
                    class="px-6 py-4 dark:bg-gradient-to-r dark:from-orange-600 dark:to-orange-700 bg-gradient-to-r from-emerald-600 to-emerald-700 border-b dark:border-orange-400/30 border-emerald-500/30">
                    <h3 class="dark:text-black text-white text-lg font-bold">
                        <i class="fas fa-history mr-2"></i>Histórico de Agendamentos
                    </h3>
                </div>

                @if($appointmentHistory->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead
                                class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-100 to-gray-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-yellow-400 text-emerald-700 uppercase tracking-wider">
                                        Serviço</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-orange-400 text-teal-700 uppercase tracking-wider">
                                        Barbeiro</th>
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
                                @foreach($appointmentHistory as $appointment)
                                    <tr
                                        class="dark:hover:bg-gradient-to-r dark:hover:from-gray-800 dark:hover:to-gray-900 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-full p-2 mr-3">
                                                    <i class="fas fa-scissors dark:text-black text-white text-sm"></i>
                                                </div>
                                                <div class="text-sm font-medium dark:text-white text-gray-900">
                                                    {{ $appointment->service->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-cut mr-2 dark:text-orange-400 text-teal-600"></i>
                                            {{ $appointment->barber->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-600">
                                            <i class="fas fa-calendar mr-2 dark:text-amber-400 text-orange-600"></i>
                                            {{ $appointment->scheduled_at->format('d/m/Y H:i') }}
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
                                            R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div
                            class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-100 to-gray-200 rounded-2xl p-8 inline-block">
                            <i class="fas fa-calendar-times text-6xl dark:text-amber-400 text-orange-600 mb-4"></i>
                            <h3 class="dark:text-white text-gray-700 text-xl font-bold mb-2">Nenhum agendamento no histórico
                            </h3>
                            <p class="dark:text-gray-400 text-gray-500 text-sm mb-4">Você ainda não tem agendamentos
                                anteriores</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Se não há agendamentos futuros -->
            @if($upcomingAppointments->count() === 0)
                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-yellow-500 border-teal-600 rounded-2xl p-12 text-center shadow-xl">
                    <div
                        class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-100 to-gray-200 rounded-2xl p-8 inline-block">
                        <i class="fas fa-calendar-plus text-6xl dark:text-yellow-400 text-teal-600 mb-4"></i>
                        <h3 class="dark:text-white text-gray-700 text-xl font-bold mb-2">Nenhum agendamento próximo</h3>
                        <p class="dark:text-gray-400 text-gray-500 text-sm mb-6">Que tal agendar seu próximo corte?</p>
                        <a href="{{ route('client.appointments.create') }}"
                            class="inline-flex items-center dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-emerald-600 to-emerald-700 dark:text-black text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Fazer Agendamento
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para Solicitar Cancelamento -->
    <div id="cancellationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="cancellationForm" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    Solicitar Cancelamento
                                </h3>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Motivo do cancelamento <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="reason" rows="3" required maxlength="500"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-white dark:bg-gray-700 focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                        placeholder="Informe o motivo do cancelamento..."></textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Máximo 500 caracteres</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Enviar Solicitação
                        </button>
                        <button type="button" onclick="closeCancellationModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Solicitar Reagendamento -->
    <div id="rescheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="rescheduleForm" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    Solicitar Reagendamento
                                </h3>
                                <div class="mt-4 space-y-6">
                                    <!-- Barbeiro (hidden field para manter o mesmo barbeiro) -->
                                    <input type="hidden" id="reschedule_barber_id" name="barber_id">
                                    <input type="hidden" id="reschedule_selected_date" name="new_date">
                                    <input type="hidden" id="reschedule_selected_time" name="new_time">

                                    <!-- Calendário -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                            <i class="fas fa-calendar mr-2"></i>Nova Data <span
                                                class="text-red-500">*</span>
                                        </label>
                                        <div
                                            class="dark:bg-gray-700 bg-gray-50 rounded-lg p-4 border dark:border-gray-600 border-gray-300">
                                            <!-- Header do Calendário -->
                                            <div class="flex items-center justify-between mb-4">
                                                <button type="button" id="reschedule-prev-month"
                                                    class="p-2 rounded-lg dark:hover:bg-gray-600 hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-left dark:text-blue-400 text-blue-600"></i>
                                                </button>
                                                <h5 id="reschedule-calendar-month-year"
                                                    class="font-bold dark:text-white text-gray-800 text-sm"></h5>
                                                <button type="button" id="reschedule-next-month"
                                                    class="p-2 rounded-lg dark:hover:bg-gray-600 hover:bg-gray-200 transition-colors">
                                                    <i
                                                        class="fas fa-chevron-right dark:text-blue-400 text-blue-600"></i>
                                                </button>
                                            </div>

                                            <!-- Dias da Semana -->
                                            <div class="grid grid-cols-7 gap-1 mb-2">
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Dom</div>
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Seg</div>
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Ter</div>
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Qua</div>
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Qui</div>
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Sex</div>
                                                <div
                                                    class="text-center p-1 font-medium text-xs dark:text-gray-400 text-gray-600">
                                                    Sáb</div>
                                            </div>

                                            <!-- Dias do Calendário -->
                                            <div id="reschedule-calendar-days" class="grid grid-cols-7 gap-1 text-sm">
                                                <!-- Dias serão gerados dinamicamente -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Horários Disponíveis -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                            <i class="fas fa-clock mr-2"></i>Novo Horário <span
                                                class="text-red-500">*</span>
                                        </label>
                                        <div id="reschedule-available-times"
                                            class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto">
                                            <div class="col-span-full text-center py-4">
                                                <div class="dark:text-gray-400 text-gray-500 text-sm">
                                                    <i class="fas fa-calendar-day text-2xl mb-2 block"></i>
                                                    <p class="font-medium">Escolha uma data primeiro</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Motivo do reagendamento <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="reason" rows="3" required maxlength="500"
                                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Informe o motivo do reagendamento..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Enviar Solicitação
                        </button>
                        <button type="button" onclick="closeRescheduleModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCancellationModal(appointmentId) {
            const modal = document.getElementById('cancellationModal');
            const form = document.getElementById('cancellationForm');
            form.action = `/client/appointments/${appointmentId}/request-cancellation`;
            modal.classList.remove('hidden');
        }

        function closeCancellationModal() {
            const modal = document.getElementById('cancellationModal');
            modal.classList.add('hidden');
            // Limpar o formulário
            document.getElementById('cancellationForm').reset();
        }

        // Variáveis globais para o reagendamento
        let rescheduleCurrentDate = new Date();
        let rescheduleAvailableDates = [];
        let rescheduleCurrentBarberId = null;

        function openRescheduleModal(appointmentId, barberId) {
            const modal = document.getElementById('rescheduleModal');
            const form = document.getElementById('rescheduleForm');
            form.action = `/client/appointments/${appointmentId}/request-reschedule`;

            // Definir o barbeiro
            document.getElementById('reschedule_barber_id').value = barberId;
            rescheduleCurrentBarberId = barberId;

            // Limpar seleção anterior
            document.getElementById('reschedule_selected_date').value = '';
            document.getElementById('reschedule_selected_time').value = '';

            // Resetar calendário
            rescheduleCurrentDate = new Date();

            // Carregar datas disponíveis e inicializar calendário
            loadRescheduleAvailableDates(barberId);

            modal.classList.remove('hidden');
        }

        function loadRescheduleAvailableDates(barberId) {
            fetch(`/api/barber/${barberId}/available-dates`)
                .then(response => response.json())
                .then(data => {
                    if (data.available_dates && Array.isArray(data.available_dates)) {
                        rescheduleAvailableDates = data.available_dates;
                        renderRescheduleCalendar();
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar datas:', error);
                    rescheduleAvailableDates = [];
                    renderRescheduleCalendar();
                });
        }

        function renderRescheduleCalendar() {
            const monthYear = document.getElementById('reschedule-calendar-month-year');
            const calendarDays = document.getElementById('reschedule-calendar-days');

            monthYear.textContent = rescheduleCurrentDate.toLocaleDateString('pt-BR', {
                month: 'long',
                year: 'numeric'
            });

            const firstDay = new Date(rescheduleCurrentDate.getFullYear(), rescheduleCurrentDate.getMonth(), 1);
            const lastDay = new Date(rescheduleCurrentDate.getFullYear(), rescheduleCurrentDate.getMonth() + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            calendarDays.innerHTML = '';

            for (let i = 0; i < 42; i++) {
                const day = new Date(startDate);
                day.setDate(startDate.getDate() + i);

                const dayElement = document.createElement('button');
                dayElement.type = 'button';
                dayElement.className = 'aspect-square p-1 text-xs rounded-lg transition-colors';
                dayElement.textContent = day.getDate();

                const dateString = day.toISOString().split('T')[0];
                const isCurrentMonth = day.getMonth() === rescheduleCurrentDate.getMonth();
                const isAvailable = rescheduleAvailableDates.includes(dateString);
                const isPast = day < new Date().setHours(0, 0, 0, 0);

                if (!isCurrentMonth) {
                    dayElement.className += ' text-gray-400 dark:text-gray-600 cursor-not-allowed';
                    dayElement.disabled = true;
                } else if (isPast || !isAvailable) {
                    dayElement.className += ' text-gray-400 dark:text-gray-600 cursor-not-allowed';
                    dayElement.disabled = true;
                } else {
                    dayElement.className += ' text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-blue-900';
                    dayElement.addEventListener('click', () => selectRescheduleDate(dateString));
                }

                calendarDays.appendChild(dayElement);
            }
        }

        function selectRescheduleDate(dateString) {
            // Destacar data selecionada
            document.querySelectorAll('#reschedule-calendar-days button').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-100', 'dark:hover:bg-blue-900');
                if (!btn.disabled) {
                    btn.classList.add('hover:bg-blue-100', 'dark:hover:bg-blue-900');
                }
            });

            event.target.classList.add('bg-blue-500', 'text-white');
            event.target.classList.remove('hover:bg-blue-100', 'dark:hover:bg-blue-900');

            // Salvar data selecionada
            document.getElementById('reschedule_selected_date').value = dateString;

            // Carregar horários disponíveis
            loadRescheduleAvailableTimes(rescheduleCurrentBarberId, dateString);
        }

        function loadRescheduleAvailableTimes(barberId, selectedDate) {
            const timesContainer = document.getElementById('reschedule-available-times');
            timesContainer.innerHTML = '<div class="col-span-full text-center py-4"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';

            fetch(`/api/barber/${barberId}/available-times/${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    timesContainer.innerHTML = '';

                    if (data.available_times && Array.isArray(data.available_times) && data.available_times.length > 0) {
                        data.available_times.forEach(time => {
                            const timeButton = document.createElement('button');
                            timeButton.type = 'button';
                            timeButton.className = 'p-2 text-sm rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-blue-900 hover:border-blue-300 dark:hover:border-blue-500 transition-colors';
                            timeButton.textContent = time;
                            timeButton.addEventListener('click', () => selectRescheduleTime(time, timeButton));
                            timesContainer.appendChild(timeButton);
                        });
                    } else {
                        timesContainer.innerHTML = `
                            <div class="col-span-full text-center py-4">
                                <div class="text-gray-500 dark:text-gray-400 text-sm">
                                    <i class="fas fa-clock-o text-2xl mb-2 block"></i>
                                    <p class="font-medium">Nenhum horário disponível</p>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar horários:', error);
                    timesContainer.innerHTML = `
                        <div class="col-span-full text-center py-4">
                            <div class="text-red-500 text-sm">
                                <i class="fas fa-exclamation-triangle text-2xl mb-2 block"></i>
                                <p class="font-medium">Erro ao carregar horários</p>
                            </div>
                        </div>
                    `;
                });
        }

        function selectRescheduleTime(time, buttonElement) {
            // Remover seleção anterior
            document.querySelectorAll('#reschedule-available-times button').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white', 'border-blue-500');
                btn.classList.add('border-gray-300', 'dark:border-gray-600');
            });

            // Destacar horário selecionado
            buttonElement.classList.add('bg-blue-500', 'text-white', 'border-blue-500');
            buttonElement.classList.remove('border-gray-300', 'dark:border-gray-600');

            // Salvar horário selecionado
            document.getElementById('reschedule_selected_time').value = time;
        }

        function closeRescheduleModal() {
            const modal = document.getElementById('rescheduleModal');
            modal.classList.add('hidden');

            // Limpar o formulário
            document.getElementById('rescheduleForm').reset();

            // Limpar seleções
            document.getElementById('reschedule_selected_date').value = '';
            document.getElementById('reschedule_selected_time').value = '';

            // Limpar calendário
            document.getElementById('reschedule-available-times').innerHTML = `
                <div class="col-span-full text-center py-4">
                    <div class="dark:text-gray-400 text-gray-500 text-sm">
                        <i class="fas fa-calendar-day text-2xl mb-2 block"></i>
                        <p class="font-medium">Escolha uma data primeiro</p>
                    </div>
                </div>
            `;
        }

        // Event listeners para navegação do calendário
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('reschedule-prev-month').addEventListener('click', function () {
                rescheduleCurrentDate.setMonth(rescheduleCurrentDate.getMonth() - 1);
                renderRescheduleCalendar();
            });

            document.getElementById('reschedule-next-month').addEventListener('click', function () {
                rescheduleCurrentDate.setMonth(rescheduleCurrentDate.getMonth() + 1);
                renderRescheduleCalendar();
            });
        });

        // Fechar modais ao clicar fora
        document.addEventListener('click', function (event) {
            const cancellationModal = document.getElementById('cancellationModal');
            const rescheduleModal = document.getElementById('rescheduleModal');

            if (event.target === cancellationModal) {
                closeCancellationModal();
            }
            if (event.target === rescheduleModal) {
                closeRescheduleModal();
            }
        });
    </script>
</x-app-layout>