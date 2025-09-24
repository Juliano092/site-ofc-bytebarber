<x-app-layout>
    <div
        class="dark:bg-gradient-to-br dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-br from-gray-100 via-white to-gray-200 min-h-screen transition-all duration-300">

        <!-- Header -->
        <div class="pt-8 pb-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="dark:bg-gradient-to-r dark:from-black dark:via-gray-900 dark:to-black bg-gradient-to-r from-white via-gray-50 to-gray-100 border-2 dark:border-yellow-500 border-teal-600 px-6 py-4 rounded-xl shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="font-bold text-2xl dark:text-yellow-400 text-teal-700">
                                <i class="fas fa-eye mr-3"></i>Detalhes do Agendamento
                            </h2>
                            <p class="dark:text-white text-gray-600 text-sm mt-1">Visualize informações completas do
                                agendamento</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                class="dark:bg-gradient-to-r dark:from-indigo-500 dark:to-indigo-600 dark:hover:from-indigo-600 dark:hover:to-indigo-700 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 dark:text-white text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>
                            <a href="{{ route('admin.appointments.index') }}"
                                class="dark:bg-gradient-to-r dark:from-gray-600 dark:to-gray-700 dark:hover:from-gray-700 dark:hover:to-gray-800 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 dark:text-white text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-arrow-left mr-2"></i>Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="dark:bg-gradient-to-br dark:from-gray-900 dark:to-black bg-gradient-to-br from-white to-gray-100 border-2 dark:border-orange-400 border-emerald-600 rounded-2xl p-6 shadow-xl">

                <!-- Status e Ações de Aprovação -->
                <div class="mb-6 p-4 rounded-xl dark:bg-gray-800 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <span class="text-lg font-semibold dark:text-white text-gray-800">Status:</span>
                            <span class="px-4 py-2 text-sm font-bold rounded-full
                                @if($appointment->status === 'completed') bg-gradient-to-r from-emerald-500 to-green-500 text-white
                                @elseif($appointment->status === 'scheduled') bg-gradient-to-r from-blue-500 to-indigo-500 text-white
                                @elseif($appointment->status === 'pending') bg-gradient-to-r from-yellow-500 to-orange-500 text-white
                                @elseif($appointment->status === 'in_progress') bg-gradient-to-r from-purple-500 to-pink-500 text-white
                                @elseif($appointment->status === 'cancelled') bg-gradient-to-r from-red-500 to-pink-500 text-white
                                @elseif($appointment->status === 'rejected') bg-gradient-to-r from-red-600 to-red-700 text-white
                                @else bg-gradient-to-r from-gray-500 to-slate-500 text-white @endif">
                                {{ $appointment->status_in_portuguese }}
                            </span>
                        </div>

                        @if($appointment->status === 'pending')
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.appointments.approve', $appointment) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="dark:bg-green-600 bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 hover:scale-105"
                                        onclick="return confirm('Aprovar este agendamento?')">
                                        <i class="fas fa-check mr-2"></i>Aprovar
                                    </button>
                                </form>
                                <form action="{{ route('admin.appointments.reject', $appointment) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="dark:bg-orange-600 bg-orange-500 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 hover:scale-105"
                                        onclick="return confirm('Rejeitar este agendamento?')">
                                        <i class="fas fa-times mr-2"></i>Rejeitar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informações do Agendamento -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Informações do Cliente -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-yellow-400 text-emerald-700 text-lg font-bold mb-4">
                            <i class="fas fa-user mr-2"></i>Cliente
                        </h3>
                        <div class="space-y-3">
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
                            @if($appointment->client->phone)
                                <div class="flex items-center dark:text-gray-300 text-gray-600">
                                    <i class="fas fa-phone mr-3 dark:text-green-400 text-green-600"></i>
                                    {{ $appointment->client->phone }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informações do Barbeiro -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-orange-400 text-teal-700 text-lg font-bold mb-4">
                            <i class="fas fa-cut mr-2"></i>Barbeiro
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div
                                    class="dark:bg-gradient-to-r dark:from-orange-500 dark:to-orange-600 bg-gradient-to-r from-teal-600 to-teal-700 rounded-full p-2 mr-3">
                                    <i class="fas fa-cut text-white text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium dark:text-white text-gray-900">
                                        {{ $appointment->barber->user->name }}
                                    </div>
                                    <div class="text-sm dark:text-gray-300 text-gray-500">
                                        {{ $appointment->barber->user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Serviço -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-purple-400 text-purple-700 text-lg font-bold mb-4">
                            <i class="fas fa-scissors mr-2"></i>Serviço
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div
                                    class="dark:bg-gradient-to-r dark:from-purple-500 dark:to-purple-600 bg-gradient-to-r from-purple-600 to-purple-700 rounded-full p-2 mr-3">
                                    <i class="fas fa-scissors text-white text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium dark:text-white text-gray-900">
                                        {{ $appointment->service->name }}
                                    </div>
                                    <div class="text-sm dark:text-gray-300 text-gray-500">
                                        {{ $appointment->service->duration }} minutos
                                    </div>
                                </div>
                            </div>
                            @if($appointment->service->description)
                                <div class="dark:text-gray-300 text-gray-600 text-sm">
                                    <i class="fas fa-info-circle mr-2 dark:text-blue-400 text-blue-600"></i>
                                    {{ $appointment->service->description }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informações de Data/Hora e Valor -->
                    <div class="dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-blue-400 text-blue-700 text-lg font-bold mb-4">
                            <i class="fas fa-calendar-alt mr-2"></i>Agendamento
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center dark:text-gray-300 text-gray-600">
                                <i class="fas fa-calendar mr-3 dark:text-blue-400 text-blue-600"></i>
                                <span class="font-medium">{{ $appointment->scheduled_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center dark:text-gray-300 text-gray-600">
                                <i class="fas fa-clock mr-3 dark:text-green-400 text-green-600"></i>
                                <span class="font-medium">{{ $appointment->scheduled_at->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center dark:text-yellow-400 text-emerald-700">
                                <i class="fas fa-dollar-sign mr-3"></i>
                                <span class="font-bold text-lg">R$
                                    {{ number_format($appointment->price, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Observações/Notas (se houver) -->
                @if($appointment->notes)
                    <div class="mt-6 dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                        <h3 class="dark:text-amber-400 text-amber-700 text-lg font-bold mb-4">
                            <i class="fas fa-sticky-note mr-2"></i>Observações
                        </h3>
                        <p class="dark:text-gray-300 text-gray-600">{{ $appointment->notes }}</p>
                    </div>
                @endif

                <!-- Histórico de Datas -->
                <div class="mt-6 dark:bg-gray-800 bg-gray-50 rounded-xl p-6">
                    <h3 class="dark:text-pink-400 text-pink-700 text-lg font-bold mb-4">
                        <i class="fas fa-history mr-2"></i>Histórico
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center dark:text-gray-300 text-gray-600">
                            <i class="fas fa-plus-circle mr-3 dark:text-green-400 text-green-600"></i>
                            <div>
                                <span class="font-medium">Criado em:</span>
                                <div>{{ $appointment->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        @if($appointment->updated_at != $appointment->created_at)
                            <div class="flex items-center dark:text-gray-300 text-gray-600">
                                <i class="fas fa-edit mr-3 dark:text-blue-400 text-blue-600"></i>
                                <div>
                                    <span class="font-medium">Atualizado em:</span>
                                    <div>{{ $appointment->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>