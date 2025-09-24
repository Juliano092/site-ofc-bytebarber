@extends('layouts.app')

@section('content')
    <div class="dark:bg-gray-900 bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Cabeçalho -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold dark:text-white text-gray-900 mb-2">
                    <i class="fas fa-calendar-alt mr-3 dark:text-yellow-400 text-orange-600"></i>
                    Meus Agendamentos
                </h1>
                <p class="dark:text-gray-300 text-gray-600">Gerencie seus agendamentos e aprove solicitações dos clientes
                </p>
            </div>

            <!-- Filtros -->
            <div class="dark:bg-gray-800 bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('barber.appointments.index') }}"
                    class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-4 sm:gap-4">
                    <div>
                        <label for="status"
                            class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-white border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                            <option value="">Todos os Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Agendado
                            </option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em
                                Andamento</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejeitado
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="date"
                            class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-1">Data</label>
                        <input type="date" name="date" id="date" value="{{ request('date') }}"
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-white border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="search" class="block text-sm font-medium dark:text-gray-300 text-gray-700 mb-1">Buscar
                            Cliente</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nome do cliente..."
                            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-white border border-gray-300 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 w-full">
                            <i class="fas fa-search mr-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de Agendamentos -->
            <div class="dark:bg-gray-800 bg-white rounded-lg shadow-sm overflow-hidden">
                @if($appointments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y dark:divide-gray-700 divide-gray-200">
                            <thead class="dark:bg-gray-700 bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 text-gray-500 uppercase tracking-wider">
                                        Cliente
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 text-gray-500 uppercase tracking-wider">
                                        Serviço
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 text-gray-500 uppercase tracking-wider">
                                        Data/Hora
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 text-gray-500 uppercase tracking-wider">
                                        Preço
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="dark:bg-gray-800 bg-white divide-y dark:divide-gray-700 divide-gray-200">
                                @foreach($appointments as $appointment)
                                    <tr class="hover:dark:bg-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center">
                                                        <span class="text-white font-medium text-sm">
                                                            {{ substr($appointment->client->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium dark:text-white text-gray-900">
                                                        {{ $appointment->client->name }}
                                                    </div>
                                                    <div class="text-sm dark:text-gray-300 text-gray-500">
                                                        {{ $appointment->client->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-900">
                                            <div class="font-medium">{{ $appointment->service->name }}</div>
                                            <div class="text-sm dark:text-gray-400 text-gray-500">
                                                {{ $appointment->service->duration }} min
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-900">
                                            <div class="font-medium">{{ $appointment->scheduled_at->format('d/m/Y') }}</div>
                                            <div class="text-sm dark:text-gray-400 text-gray-500">
                                                {{ $appointment->scheduled_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
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
                                            class="px-6 py-4 whitespace-nowrap text-sm dark:text-gray-300 text-gray-900 font-medium">
                                            R$ {{ number_format($appointment->price, 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                @if($appointment->status === 'pending')
                                                    <!-- Botão Aprovar -->
                                                    <form action="{{ route('barber.appointments.approve', $appointment) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-3 py-1 rounded-lg text-xs font-medium transition-all duration-200"
                                                            onclick="return confirm('Tem certeza que deseja aprovar este agendamento?')">
                                                            <i class="fas fa-check mr-1"></i>Aprovar
                                                        </button>
                                                    </form>

                                                    <!-- Botão Rejeitar -->
                                                    <form action="{{ route('barber.appointments.reject', $appointment) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 py-1 rounded-lg text-xs font-medium transition-all duration-200"
                                                            onclick="return confirm('Tem certeza que deseja rejeitar este agendamento?')">
                                                            <i class="fas fa-times mr-1"></i>Rejeitar
                                                        </button>
                                                    </form>
                                                @elseif($appointment->status === 'scheduled')
                                                    <!-- Botão Iniciar Serviço -->
                                                    <form action="{{ route('barber.appointments.status', $appointment) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="in_progress">
                                                        <button type="submit"
                                                            class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white px-3 py-1 rounded-lg text-xs font-medium transition-all duration-200">
                                                            <i class="fas fa-play mr-1"></i>Iniciar
                                                        </button>
                                                    </form>
                                                @elseif($appointment->status === 'in_progress')
                                                    <!-- Botão Concluir -->
                                                    <form action="{{ route('barber.appointments.status', $appointment) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit"
                                                            class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white px-3 py-1 rounded-lg text-xs font-medium transition-all duration-200">
                                                            <i class="fas fa-check mr-1"></i>Concluir
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="dark:bg-gray-800 bg-white px-4 py-3 border-t dark:border-gray-700 border-gray-200">
                        {{ $appointments->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-calendar-times text-4xl dark:text-gray-400 text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium dark:text-gray-300 text-gray-900 mb-2">Nenhum agendamento encontrado</h3>
                        <p class="dark:text-gray-400 text-gray-500">
                            @if(request()->hasAny(['status', 'date', 'search']))
                                Tente ajustar os filtros para encontrar agendamentos.
                            @else
                                Quando você tiver agendamentos, eles aparecerão aqui.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts para confirmação -->
    <script>
        // Script para mostrar feedback visual nos botões
        document.querySelectorAll('form button').forEach(button => {
            button.addEventListener('click', function (e) {
                if (this.getAttribute('onclick') && !this.getAttribute('onclick').includes('confirm')) {
                    return;
                }

                // Desabilita o botão temporariamente para evitar cliques duplicados
                this.disabled = true;
                setTimeout(() => {
                    this.disabled = false;
                }, 2000);
            });
        });
    </script>
@endsection