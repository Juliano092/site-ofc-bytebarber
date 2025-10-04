<x-app-layout>
    <div class="p-6 sm:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="dark:bg-gray-800 bg-white rounded-lg shadow-xl p-6 sm:p-8">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h2 class="text-2xl font-bold text-teal-700 dark:text-yellow-400 mb-4 sm:mb-0">
                        <i class="fas fa-users mr-2"></i>Consultar Usuários
                    </h2>
                    <a href="{{ route('admin.users.create') }}" class="btn-primary">
                        <i class="fas fa-plus mr-2"></i>Cadastrar Novo Usuário
                    </a>
                </div>

                @if (session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-md shadow-sm"
                    role="alert">
                    <p class="font-bold">Sucesso!</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <div class="overflow-x-auto rounded-lg border dark:border-gray-700">
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="th-table">Nome</th>
                                <th class="th-table">Email</th>
                                <th class="th-table">Tipo</th>
                                <th class="th-table">Barbearia</th>
                                <th class="th-table text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($usuarios as $usuario)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="td-table font-medium">{{ $usuario->name }}</td>
                                <td class="td-table">{{ $usuario->email }}</td>
                                <td class="td-table">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($usuario->user_type == 'admin') bg-red-100 text-red-800 @endif
                                            @if($usuario->user_type == 'barber') bg-blue-100 text-blue-800 @endif
                                            @if($usuario->user_type == 'client') bg-green-100 text-green-800 @endif
                                            dark:bg-opacity-20">
                                        {{ ucfirst($usuario->user_type) }}
                                    </span>
                                </td>
                                <td class="td-table">{{ $usuario->barbershop->name ?? 'N/A' }}</td>
                                <td class="td-table text-center">
                                    <a href="#"
                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">Editar</a>
                                    <a href="#"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Excluir</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum usuário cadastrado.
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
            color: #fff;
            background-image: linear-gradient(to right, #0d9488, #0f766e);
            padding: .625rem 1.25rem;
            border-radius: .5rem;
            text-align: center
        }

        .btn-primary:hover {
            background-image: linear-gradient(to right, #0f766e, #115e59)
        }

        .th-table {
            padding: .75rem 1.5rem;
            text-align: left;
            font-size: .75rem;
            font-weight: 500;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: .05em
        }

        .dark .th-table {
            color: #D1D5DB
        }

        .td-table {
            padding: .75rem 1.5rem;
            white-space: nowrap;
            font-size: .875rem;
            color: #6B7280
        }

        .dark .td-table {
            color: #D1D5DB
        }

        .td-table.font-medium {
            font-weight: 500;
            color: #111827
        }

        .dark .td-table.font-medium {
            color: #fff
        }
    </style>
</x-app-layout>