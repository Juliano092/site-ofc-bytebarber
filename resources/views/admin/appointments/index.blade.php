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
                                <i class="fas fa-calendar-alt mr-3"></i>Gerenciar Agendamentos
                            </h2>
                            <p class="dark:text-white text-gray-600 text-sm mt-1">Visualize e gerencie todos os
                                agendamentos</p>
                        </div>
                        <a href="{{ route('admin.appointments.create') }}"
                            class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 dark:hover:from-yellow-600 dark:hover:to-yellow-700 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:text-black text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>Novo Agendamento
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Modal para detalhes das solicitações -->
            <div id="requestDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="dark:bg-gray-900 bg-white rounded-lg shadow-xl max-w-lg w-full">
                        <div class="dark:bg-gray-800 bg-gray-50 px-6 py-4 border-b rounded-t-lg">
                            <h3 class="text-lg font-semibold dark:text-white text-gray-900">Detalhes da Solicitação</h3>
                        </div>
                        <div class="px-6 py-4">
                            <div id="requestDetailsContent" class="space-y-4">
                                <!-- Conteúdo será carregado dinamicamente -->
                            </div>
                        </div>
                        <div class="dark:bg-gray-800 bg-gray-50 px-6 py-4 border-t rounded-b-lg flex justify-between">
                            <button onclick="closeRequestModal()"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Fechar
                            </button>
                            <div id="requestModalActions" class="space-x-2">
                                <!-- Botões de ação serão adicionados dinamicamente -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="mb-6">
                <div
                    class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-emerald-600 rounded-2xl p-6 shadow-xl">
                    <h3 class="dark:text-orange-400 text-emerald-700 text-lg font-bold mb-4">
                        <i class="fas fa-filter mr-2"></i>Filtros
                    </h3>
                    <form method="GET" action="{{ route('admin.appointments.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium dark:text-white text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-3 py-2 dark:text-white text-gray-900">
                                <option value="">Todos</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>
                                    Agendado</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                    Confirmado</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em
                                    Andamento</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Concluído</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium dark:text-white text-gray-700 mb-1">Data</label>
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-3 py-2 dark:text-white text-gray-900">
                        </div>
                        <div>
                            <label class="block text-sm font-medium dark:text-white text-gray-700 mb-1">Barbeiro</label>
                            <select name="barber_id"
                                class="w-full dark:bg-gray-800 bg-white border dark:border-gray-600 border-gray-300 rounded-lg px-3 py-2 dark:text-white text-gray-900">
                                <option value="">Todos</option>
                                @foreach($barbers as $barber)
                                    <option value="{{ $barber->id }}" {{ request('barber_id') == $barber->id ? 'selected' : '' }}>
                                        {{ $barber->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full dark:bg-gradient-to-r dark:from-amber-600 dark:to-amber-700 bg-gradient-to-r from-orange-600 to-orange-700 dark:text-black text-white font-semibold py-2 px-4 rounded-xl hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-search mr-2"></i>Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Agendamentos -->
            <div
                class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-amber-500 border-orange-600 rounded-2xl overflow-hidden shadow-xl">

                <div
                    class="px-6 py-4 dark:bg-gradient-to-r dark:from-amber-600 dark:to-amber-700 bg-gradient-to-r from-orange-600 to-orange-700 border-b dark:border-amber-400/30 border-orange-500/30">
                    <h3 class="dark:text-black text-white text-lg font-bold">
                        <i class="fas fa-list mr-2"></i>Lista de Agendamentos
                    </h3>
                </div>

                @if($appointments->count() > 0)
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
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium dark:text-amber-400 text-orange-700 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody
                                class="dark:bg-gradient-to-b dark:from-black dark:to-gray-900 bg-gradient-to-b from-white to-gray-50 divide-y dark:divide-gray-700/50 divide-gray-200">
                                @foreach($appointments as $appointment)
                                    <tr
                                        class="dark:hover:bg-gradient-to-r dark:hover:from-gray-800 dark:hover:to-gray-900 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 transition-all duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-full p-2 mr-3">
                                                    <i class="fas fa-user dark:text-black text-white text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium dark:text-white text-gray-900">
                                                        {{ $appointment->client->name }}
                                                    </div>
                                                    <div class="text-sm dark:text-gray-300 text-gray-500">
                                                        {{ $appointment->client->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="dark:bg-gradient-to-r dark:from-orange-500 dark:to-orange-600 bg-gradient-to-r from-teal-600 to-teal-700 rounded-full p-2 mr-3">
                                                    <i class="fas fa-cut text-white text-sm"></i>
                                                </div>
                                                <div class="text-sm font-medium dark:text-white text-gray-900">
                                                    {{ $appointment->barber->user->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium dark:text-white text-gray-900">
                                                {{ $appointment->service->name }}
                                            </div>
                                            <div class="text-sm dark:text-gray-300 text-gray-500">
                                                {{ $appointment->service->duration }} min
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium dark:text-white text-gray-900">
                                                {{ $appointment->scheduled_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm dark:text-gray-300 text-gray-500">
                                                {{ $appointment->scheduled_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
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

                                                <!-- Indicadores de Solicitações -->
                                                @if($appointment->hasCancellationRequest())
                                                    <button onclick="showRequestDetails({{ $appointment->id }}, 'cancellation')"
                                                        class="px-2 py-1 bg-gradient-to-r from-red-100 to-red-200 border border-red-300 text-red-700 text-xs rounded-full font-medium hover:from-red-200 hover:to-red-300 transition-all cursor-pointer">
                                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                                        Solicita Cancelamento
                                                    </button>
                                                @endif

                                                @if($appointment->hasRescheduleRequest())
                                                    <button onclick="showRequestDetails({{ $appointment->id }}, 'reschedule')"
                                                        class="px-2 py-1 bg-gradient-to-r from-blue-100 to-blue-200 border border-blue-300 text-blue-700 text-xs rounded-full font-medium hover:from-blue-200 hover:to-blue-300 transition-all cursor-pointer">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        Solicita Reagendamento
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm dark:text-yellow-400 text-emerald-700 font-bold">
                                            R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex flex-col items-center space-y-2">
                                                <!-- Primeira linha: Botões de aprovação para agendamentos pendentes -->
                                                @if($appointment->status === 'pending')
                                                    <div class="flex space-x-1">
                                                        <form action="{{ route('admin.appointments.approve', $appointment) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dark:bg-green-600 bg-green-500 hover:bg-green-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                                title="Aprovar Agendamento"
                                                                onclick="return confirm('Aprovar este agendamento?')">
                                                                <i class="fas fa-check text-sm"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.appointments.reject', $appointment) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dark:bg-orange-600 bg-orange-500 hover:bg-orange-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                                title="Rejeitar Agendamento"
                                                                onclick="return confirm('Rejeitar este agendamento?')">
                                                                <i class="fas fa-times text-sm"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif

                                                <!-- Segunda linha: Botões de solicitações de cancelamento -->
                                                @if($appointment->hasCancellationRequest())
                                                    <div class="flex space-x-1">
                                                        <form
                                                            action="{{ route('admin.appointments.approve-cancellation', $appointment) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dark:bg-emerald-600 bg-emerald-500 hover:bg-emerald-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                                title="Aprovar Cancelamento"
                                                                onclick="return confirm('Aprovar solicitação de cancelamento?')">
                                                                <i class="fas fa-check-circle text-sm"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('admin.appointments.deny-cancellation', $appointment) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dark:bg-red-700 bg-red-600 hover:bg-red-800 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                                title="Negar Cancelamento"
                                                                onclick="return confirm('Negar solicitação de cancelamento?')">
                                                                <i class="fas fa-times-circle text-sm"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif

                                                <!-- Terceira linha: Botões de solicitações de reagendamento -->
                                                @if($appointment->hasRescheduleRequest())
                                                    <div class="flex space-x-1">
                                                        <form
                                                            action="{{ route('admin.appointments.approve-reschedule', $appointment) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dark:bg-cyan-600 bg-cyan-500 hover:bg-cyan-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                                title="Aprovar Reagendamento"
                                                                onclick="return confirm('Aprovar solicitação de reagendamento?')">
                                                                <i class="fas fa-calendar-check text-sm"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('admin.appointments.deny-reschedule', $appointment) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dark:bg-purple-700 bg-purple-600 hover:bg-purple-800 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                                title="Negar Reagendamento"
                                                                onclick="return confirm('Negar solicitação de reagendamento?')">
                                                                <i class="fas fa-calendar-times text-sm"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif

                                                <!-- Quarta linha: Botões padrão de ações -->
                                                <div class="flex space-x-1">
                                                    <a href="{{ route('admin.appointments.show', $appointment) }}"
                                                        class="dark:bg-blue-600 bg-blue-500 hover:bg-blue-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                        title="Visualizar">
                                                        <i class="fas fa-eye text-sm"></i>
                                                    </a>
                                                    <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                                        class="dark:bg-indigo-600 bg-indigo-500 hover:bg-indigo-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                        title="Editar">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </a>
                                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="dark:bg-red-600 bg-red-500 hover:bg-red-700 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110"
                                                            title="Excluir"
                                                            onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="px-6 py-4 dark:bg-gray-800 bg-gray-50 border-t dark:border-gray-700 border-gray-200">
                        {{ $appointments->withQueryString()->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div
                            class="dark:bg-gradient-to-r dark:from-gray-800 dark:to-gray-900 bg-gradient-to-r from-gray-100 to-gray-200 rounded-2xl p-8 inline-block">
                            <i class="fas fa-calendar-times text-6xl dark:text-amber-400 text-orange-600 mb-4"></i>
                            <h3 class="dark:text-white text-gray-700 text-xl font-bold mb-2">Nenhum agendamento encontrado
                            </h3>
                            <p class="dark:text-gray-400 text-gray-500 text-sm mb-4">Comece criando o primeiro agendamento
                            </p>
                            <a href="{{ route('admin.appointments.create') }}"
                                class="dark:bg-gradient-to-r dark:from-yellow-500 dark:to-yellow-600 bg-gradient-to-r from-emerald-600 to-emerald-700 dark:text-black text-white font-semibold py-2 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus mr-2"></i>Criar Agendamento
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Dados dos agendamentos para o modal (passados do backend)
        const appointmentsData = {!! $appointments->map(function ($appointment) {
    return [
        'id' => $appointment->id,
        'cancellation_reason' => $appointment->cancellation_reason,
        'cancellation_requested_at' => $appointment->cancellation_requested_at ? $appointment->cancellation_requested_at->format('d/m/Y H:i') : null,
        'reschedule_reason' => $appointment->reschedule_reason,
        'reschedule_requested_at' => $appointment->reschedule_requested_at ? $appointment->reschedule_requested_at->format('d/m/Y H:i') : null,
        'requested_new_datetime' => $appointment->requested_new_datetime ? $appointment->requested_new_datetime->format('d/m/Y H:i') : null,
        'client_name' => $appointment->client->name,
        'service_name' => $appointment->service->name,
        'current_date' => $appointment->scheduled_at->format('d/m/Y H:i')
    ];
})->keyBy('id')->toJson() !!};


        function showRequestDetails(appointmentId, requestType) {
            const appointment = appointmentsData[appointmentId];
            const modal = document.getElementById('requestDetailsModal');
            const content = document.getElementById('requestDetailsContent');
            const actions = document.getElementById('requestModalActions');

            if (!appointment) return;

            let detailsHtml = '';
            let actionsHtml = '';

            if (requestType === 'cancellation') {
                detailsHtml = `
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2 text-red-600">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h4 class="font-semibold">Solicitação de Cancelamento</h4>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Cliente:</strong> ${appointment.client_name}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Serviço:</strong> ${appointment.service_name}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Data Atual:</strong> ${appointment.current_date}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Solicitado em:</strong> ${appointment.cancellation_requested_at}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Motivo:</label>
                            <p class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-3 text-sm">${appointment.cancellation_reason || 'Não informado'}</p>
                        </div>
                    </div>
                `;

                actionsHtml = `
                    <form method="POST" action="/admin/appointments/${appointmentId}/approve-cancellation" class="inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-check mr-1"></i>Aprovar
                        </button>
                    </form>
                    <form method="POST" action="/admin/appointments/${appointmentId}/deny-cancellation" class="inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times mr-1"></i>Negar
                        </button>
                    </form>
                `;
            } else if (requestType === 'reschedule') {
                detailsHtml = `
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2 text-blue-600">
                            <i class="fas fa-calendar-alt"></i>
                            <h4 class="font-semibold">Solicitação de Reagendamento</h4>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Cliente:</strong> ${appointment.client_name}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Serviço:</strong> ${appointment.service_name}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Data Atual:</strong> ${appointment.current_date}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Solicitado em:</strong> ${appointment.reschedule_requested_at}</p>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nova Data e Horário:</label>
                                <p class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-3 text-sm">${appointment.requested_new_datetime || 'Não informado'}</p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Motivo:</label>
                            <p class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg p-3 text-sm">${appointment.reschedule_reason || 'Não informado'}</p>
                        </div>
                    </div>
                `;

                actionsHtml = `
                    <form method="POST" action="/admin/appointments/${appointmentId}/approve-reschedule" class="inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-calendar-check mr-1"></i>Aprovar
                        </button>
                    </form>
                    <form method="POST" action="/admin/appointments/${appointmentId}/deny-reschedule" class="inline">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times mr-1"></i>Negar
                        </button>
                    </form>
                `;
            }

            content.innerHTML = detailsHtml;
            actions.innerHTML = actionsHtml;
            modal.classList.remove('hidden');
        }

        function closeRequestModal() {
            document.getElementById('requestDetailsModal').classList.add('hidden');
        }

        // Fechar modal clicando fora
        document.getElementById('requestDetailsModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeRequestModal();
            }
        });
    </script>
</x-app-layout>