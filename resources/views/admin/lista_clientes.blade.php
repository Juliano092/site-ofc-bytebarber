<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Consulta de Clientes
        </h2>
    </x-slot>

    {{-- Notificação de sucesso (Toast) --}}
    {{-- Notificação de sucesso (Centralizada) --}}
    <div class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">
          {{-- NOTIFICAÇÃO DE SUCESSO --}}
        @if (session('success'))
        <div class="max-w-4xl mx-auto mt-4">
            <div class="p-4 rounded-md bg-green-100 text-green-800 border border-green-300">
                {{ session('success') }}
            </div>
        </div>
        @endif
    </div>

    {{-- CONTÊINER PRINCIPAL COM ALPINE.JS PARA GERENCIAR OS MODAIS --}}
    <div x-data="{
    showViewModal: false,
    showInactiveModal: false,
    viewCliente: {},
    inactiveClientes: @json($clientesInativos ?? []),
    
    openViewModal(cliente) {
        this.viewCliente = cliente;
        this.showViewModal = true;
        document.body.classList.add('overflow-hidden');
    },
    closeViewModal() {
        this.showViewModal = false;
        this.viewCliente = {};
        document.body.classList.remove('overflow-hidden');
    },
    openInactiveModal() {
        console.log('Abrindo modal de inativos', this.inactiveClientes); // Adicione este log
        this.showInactiveModal = true;
        document.body.classList.add('overflow-hidden');
    },
    closeInactiveModal() {
        this.showInactiveModal = false;
        document.body.classList.remove('overflow-hidden');
    }
}" x-on:keydown.escape.window="closeViewModal(); closeInactiveModal()">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold text-lg flex items-center gap-2">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Lista de Clientes Ativos
                            </h3>
                            <div class="flex items-center gap-4">
                                <!-- <button @click="openInactiveModal"
                                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                    Ver Clientes Inativos
                                </button>-->
                                <x-primary-button @click="$dispatch('open-modal', 'cadastrar-cliente')">
                                    + Cadastrar Cliente
                                </x-primary-button>
                            </div>
                        </div>

                        {{-- Tabela de Clientes Ativos --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-t border-gray-200 dark:border-gray-700">
                                <thead
                                    class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold">Nome</th>
                                        <th class="px-4 py-3 text-left font-semibold">E-mail</th>
                                        <th class="px-4 py-3 text-left font-semibold">Telefone</th>
                                        <th class="px-4 py-3 text-center font-semibold">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($clientes as $cliente)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->nome_cliente }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->email }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $cliente->telefone }}</td>
                                        <td class="px-4 py-3 text-center space-x-4 whitespace-nowrap">
                                            <button @click='openViewModal(@json($cliente))'
                                                class="font-medium text-blue-600 dark:text-blue-400 hover:underline">Ver</button>
                                            <a href="{{ route('admin.clientes.edit', $cliente->id) }}"
                                                class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Editar</a>
                                            <button
                                                x-on:click.prevent='viewCliente = @json($cliente); $dispatch("open-modal", "confirmar-delecao-cliente")'
                                                class="font-medium text-red-600 dark:text-red-400 hover:underline">
                                                Desativar
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            Nenhum cliente cadastrado ainda.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DE VISUALIZAÇÃO --}}
        <div x-show="showViewModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4"
            aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="fixed inset-0 bg-black/70" aria-hidden="true" @click="closeViewModal()"></div>
            <div x-show="showViewModal" x-transition @click.away="closeViewModal()"
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full relative z-10">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <h2 id="modal-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100"
                            x-text="`Dados de ${viewCliente.nome_cliente}`">Dados do Cliente</h2>
                        <button @click="closeViewModal()"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200">&times;</button>
                    </div>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-200">
                        <div>
                            <p class="text-xs text-gray-500">Nome</p>
                            <p class="mt-1 font-medium" x-text="viewCliente.nome_cliente || '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">E-mail</p>
                            <p class="mt-1 font-medium" x-text="viewCliente.email || '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Telefone</p>
                            <p class="mt-1" x-text="viewCliente.telefone || '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">CPF</p>
                            <p class="mt-1" x-text="viewCliente.cpf || '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">CEP</p>
                            <p class="mt-1" x-text="viewCliente.cep || '-'"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Bairro</p>
                            <p class="mt-1" x-text="viewCliente.bairro || '-'"></p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-500">Nome da Barbearia</p>
                            <p class="mt-1" x-text="viewCliente.nome_barbearia || '-'"></p>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 pt-4">
                        <x-secondary-button @click="closeViewModal()">Fechar</x-secondary-button>
                        <a :href="`/admin/clientes/${viewCliente.id}/edit`"
                            class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Editar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DE CADASTRO --}}
        <x-modal name="cadastrar-cliente" :show="$errors->isNotEmpty()" maxWidth="2xl" focusable>
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                    📝 Cadastrar Novo Cliente
                </h2>
                <form method="POST" action="{{ route('admin.clientes.store') }}" class="space-y-6" x-data="{
                        cep: '', bairro: '', loading: false,
                        fetchAddress() {
                            this.loading = true;
                            fetch(`https://viacep.com.br/ws/${this.cep}/json/`)
                                .then(response => response.json())
                                .then(data => {
                                    if (!data.erro) { this.bairro = data.bairro; }
                                    this.loading = false;
                                }).catch(() => this.loading = false);
                        }
                    }">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="nome_cliente" value="Nome do Cliente" />
                            <x-text-input id="nome_cliente" name="nome_cliente" type="text" class="mt-1 block w-full"
                                :value="old('nome_cliente')" required autofocus />
                            <x-input-error :messages="$errors->get('nome_cliente')" class="mt-2" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="email" value="E-mail" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="cpf" value="CPF (Opcional)" />
                            <x-text-input x-mask="999.999.999-99" id="cpf" name="cpf" type="text"
                                class="mt-1 block w-full" :value="old('cpf')" placeholder="000.000.000-00" />
                            <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="telefone" value="Telefone (Opcional)" />
                            <x-text-input x-mask="(99) 99999-9999" id="telefone" name="telefone" type="text"
                                class="mt-1 block w-full" :value="old('telefone')" placeholder="(00) 00000-0000" />
                            <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="cep" value="CEP (Opcional)" />
                            <x-text-input x-mask="99999-999" id="cep" name="cep" type="text" class="mt-1 block w-full"
                                x-model="cep" @blur="fetchAddress" :value="old('cep')" placeholder="00000-000" />
                            <x-input-error :messages="$errors->get('cep')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="bairro" value="Bairro (Opcional)" />
                            <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full"
                                x-model="bairro" x-bind:disabled="loading" :value="old('bairro')" />
                            <x-input-error :messages="$errors->get('bairro')" class="mt-2" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="nome_barbearia" value="Nome da Barbearia (Opcional)" />
                            <x-text-input id="nome_barbearia" name="nome_barbearia" type="text"
                                class="mt-1 block w-full" :value="old('nome_barbearia')" />
                            <x-input-error :messages="$errors->get('nome_barbearia')" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                        <x-secondary-button type="button" @click="$dispatch('close')">Cancelar</x-secondary-button>
                        <x-primary-button>Salvar Cliente</x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>

        {{-- MODAL DE CONFIRMAÇÃO PARA DESATIVAR --}}
        <x-modal name="confirmar-delecao-cliente" focusable>
            <form method="post" x-bind:action="`/admin/clientes/${viewCliente.id}`" class="p-6">
                @csrf
                @method('delete')
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tem certeza?</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">O cliente <strong
                        x-text="viewCliente.nome_cliente"></strong> será movido para a lista de inativos.</p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                    <x-danger-button class="ms-3">Sim, Desativar Cliente</x-danger-button>
                </div>
            </form>
        </x-modal>

        {{-- MODAL DE CLIENTES INATIVOS --}}
        <div x-show="showInactiveModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4" aria-labelledby="modal-inactive-title"
            role="dialog" aria-modal="true" style="display: none;">

            <div class="fixed inset-0 bg-black/70" aria-hidden="true" @click="closeInactiveModal()"></div>

            <div x-show="showInactiveModal" x-transition
                class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-3xl w-full relative z-10 overflow-hidden">

                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <h2 id="modal-inactive-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            Clientes Inativos
                        </h2>
                        <button @click="closeInactiveModal()"
                            class="text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200">&times;
                        </button>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full border-t border-gray-200 dark:border-gray-700">
                            <thead
                                class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Nome</th>
                                    <th class="px-4 py-3 text-left font-semibold">E-mail</th>
                                    <th class="px-4 py-3 text-left font-semibold">Telefone</th>
                                    <th class="px-4 py-3 text-center font-semibold">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-if="inactiveClientes.length > 0">
                                    <template x-for="cliente in inactiveClientes" :key="cliente.id">
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td class="px-4 py-3 whitespace-nowrap" x-text="cliente.nome_cliente"></td>
                                            <td class="px-4 py-3 whitespace-nowrap" x-text="cliente.email"></td>
                                            <td class="px-4 py-3 whitespace-nowrap" x-text="cliente.telefone"></td>
                                            <td class="px-4 py-3 text-center">
                                                <form method="POST" :action="`/admin/clientes/${cliente.id}/restore`">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="font-medium text-green-600 dark:text-green-400 hover:underline">
                                                        Reativar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="inactiveClientes.length === 0">
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            Nenhum cliente inativo encontrado.
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end border-t border-gray-100 dark:border-gray-700 pt-4">
                        <x-secondary-button @click="closeInactiveModal()">Fechar</x-secondary-button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>