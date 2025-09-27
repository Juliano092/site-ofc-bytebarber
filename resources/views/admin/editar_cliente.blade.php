<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Cliente: <span class="text-emerald-500">{{ $cliente->nome_cliente }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('admin.clientes.update', $cliente->id) }}" x-data="{
                              cep: '{{ old('cep', $cliente->cep) }}',
                              bairro: '{{ old('bairro', $cliente->bairro) }}',
                              loading: false,
                              fetchAddress() { /* ... a função fetchAddress continua a mesma ... */ }
                          }">
                        @csrf
                        @method('PUT') {{-- Informa ao Laravel que esta é uma atualização --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <x-input-label for="nome_cliente" value="Nome do Cliente" />
                                <x-text-input id="nome_cliente" name="nome_cliente" type="text"
                                    class="mt-1 block w-full" :value="old('nome_cliente', $cliente->nome_cliente)"
                                    required autofocus />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="email" value="E-mail" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', $cliente->email)" required />
                            </div>

                            <div>
                                <x-input-label for="cpf" value="CPF (Opcional)" />
                                <x-text-input x-mask="999.999.999-99" id="cpf" name="cpf" type="text"
                                    class="mt-1 block w-full" :value="old('cpf', $cliente->cpf)"
                                    placeholder="000.000.000-00" />
                            </div>

                            <div>
                                <x-input-label for="telefone" value="Telefone (Opcional)" />
                                <x-text-input x-mask="(99) 99999-9999" id="telefone" name="telefone" type="text"
                                    class="mt-1 block w-full" :value="old('telefone', $cliente->telefone)"
                                    placeholder="(00) 00000-0000" />
                            </div>

                            <div>
                                <x-input-label for="cep" value="CEP (Opcional)" />
                                <x-text-input x-mask="99999-999" id="cep" name="cep" type="text"
                                    class="mt-1 block w-full" x-model="cep" @blur="fetchAddress"
                                    placeholder="00000-000" />
                            </div>

                            <div>
                                <x-input-label for="bairro" value="Bairro (Opcional)" />
                                <x-text-input id="bairro" name="bairro" type="text" class="mt-1 block w-full"
                                    x-model="bairro" x-bind:disabled="loading" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="nome_barbearia" value="Nome da Barbearia (Opcional)" />
                                <x-text-input id="nome_barbearia" name="nome_barbearia" type="text"
                                    class="mt-1 block w-full"
                                    :value="old('nome_barbearia', $cliente->nome_barbearia)" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 gap-4">
                            <a href="{{ route('admin.clientes.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancelar
                            </a>
                            <x-primary-button>
                                Atualizar Cliente
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>