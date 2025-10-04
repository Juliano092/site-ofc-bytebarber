<x-app-layout>
    <div class="p-6 sm:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="dark:bg-gray-800 bg-white rounded-lg shadow-xl p-6 sm:p-8">

                {{-- CABEÇALHO: Título e Botão de Cadastrar --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h2 class="text-2xl font-bold text-teal-700 dark:text-yellow-400 mb-4 sm:mb-0">
                        <i class="fas fa-store mr-2"></i>Consultar Barbearias
                    </h2>
                    <a href="{{ route('admin.barbershops.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Cadastrar Nova Barbearia
                    </a>
                </div>

                {{-- Mensagem de Sucesso (que virá após o cadastro) --}}
                @if (session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-md shadow-sm"
                    role="alert">
                    <p class="font-bold">Sucesso!</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                {{-- Tabela de Listagem --}}
                <div class="overflow-x-auto rounded-lg border dark:border-gray-700">
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nome</th>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Cidade/Estado</th>
                                <th
                                    class="py-3 px-6 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Telefone</th>
                                <th
                                    class="py-3 px-6 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="py-3 px-6 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($barbearias as $barbearia)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td
                                    class="py-4 px-6 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $barbearia->name }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $barbearia->city }} / {{ $barbearia->state }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $barbearia->phone }}
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-center">
                                    @if ($barbearia->active)
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">Ativo</span>
                                    @else
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">Inativo</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap text-sm font-medium text-center">
                                    {{-- Link de Edição --}}
                                    <a href="{{ route('admin.barbershops.edit', $barbearia->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4 font-semibold">
                                        Editar
                                    </a>

                                    {{-- Formulário de Exclusão com Confirmação --}}
                                    <form action="{{ route('admin.barbershops.destroy', $barbearia->id) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Tem certeza que deseja excluir esta barbearia? Todos os dados relacionados serão perdidos.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-semibold">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400">
                                    Nenhuma barbearia foi cadastrada ainda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    <style>
        .btn-primary {
            color: white;
            background-image: linear-gradient(to right, #0d9488, #0f766e);
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            text-align: center;
        }

        .btn-primary:hover {
            background-image: linear-gradient(to right, #0f766e, #115e59);
        }
    </style>
</x-app-layout>