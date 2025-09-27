{{-- Caminho: resources/views/admin/clientes_inativos.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Clientes Inativos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alerta de sucesso (para quando um cliente for reativado) --}}
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="bg-emerald-100 dark:bg-emerald-900 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-200 p-4 mb-6 rounded-lg shadow-md"
                role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Link para voltar para a lista de clientes ativos --}}
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('admin.clientes.index') }}"
                            class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                            &larr; Voltar para a lista de clientes ativos
                        </a>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nome do Cliente</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clientesInativos as $cliente)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $cliente->nome_cliente }}
                                    </td>
                                    <td class="px-6 py-4">{{ $cliente->email }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            Inativo
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{-- Formulário com o botão ATIVAR --}}
                                        <form action="{{ route('admin.clientes.ativar', $cliente->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="font-medium text-emerald-600 dark:text-emerald-500 hover:underline">
                                                Ativar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Não há clientes inativos.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>