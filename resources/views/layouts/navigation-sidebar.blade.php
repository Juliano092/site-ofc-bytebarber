{{-- A sidebar terá seu próprio controle de abrir/fechar para telas pequenas --}}
<div x-data="{ open: false }" class="flex">
    <div
        class="flex flex-col w-64 h-screen px-4 py-8 bg-gradient-to-b from-slate-700 to-teal-700 dark:from-gray-800 dark:to-indigo-900 border-r border-emerald-500 dark:border-indigo-600">
        <a href="{{ route('dashboard') }}"
            class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-teal-500 dark:from-indigo-400 dark:to-purple-500 bg-clip-text text-transparent mx-auto">
            ByteBarber
        </a>

        <div class="flex flex-col justify-between flex-1 mt-6">
            <nav>
                {{-- Link do Dashboard (simples) --}}
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 mt-5 rounded-md transition-colors duration-300 transform 
                        {{ request()->routeIs('dashboard') 
                            ? 'bg-emerald-500 dark:bg-indigo-600 text-white' 
                            : 'text-gray-200 hover:bg-slate-600 dark:hover:bg-gray-700 hover:text-gray-100' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5"></i>
                    <span class="mx-4 font-medium">Dashboard</span>
                </a>

                {{-- =============================================== --}}
                {{-- MENU DROPDOWN PARA BARBEARIAS --}}
                {{-- =============================================== --}}
                <div x-data="{ open: {{ request()->routeIs('admin.barbershops.*') ? 'true' : 'false' }} }" class="mt-5">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 rounded-md transition-colors duration-300 transform 
                        {{ request()->routeIs('admin.barbershops.*') 
                            ? 'bg-emerald-500 dark:bg-indigo-600 text-white' 
                            : 'text-gray-200 hover:bg-slate-600 dark:hover:bg-gray-700 hover:text-gray-100' }}">
                        <div class="flex items-center">
                            <i class="fas fa-store w-5 h-5"></i>
                            <span class="mx-4 font-medium">Barbearias</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms class="mt-2 ml-4 space-y-2">
                        <a href="{{ route('admin.barbershops.create') }}"
                            class="block px-4 py-2 rounded-md text-sm {{ request()->routeIs('admin.barbershops.create') ? 'text-emerald-300 dark:text-indigo-300 font-bold' : 'text-gray-300 hover:text-white' }}">
                            Cadastrar Barbearia
                        </a>
                        <a href="{{ route('admin.barbershops.index') }}"
                            class="block px-4 py-2 rounded-md text-sm {{ request()->routeIs('admin.barbershops.index') ? 'text-emerald-300 dark:text-indigo-300 font-bold' : 'text-gray-300 hover:text-white' }}">
                            Consultar Barbearias
                        </a>
                    </div>
                </div>


                {{-- =============================================== --}}
                {{-- NOVO MENU DROPDOWN PARA USUÁRIOS --}}
                {{-- =============================================== --}}
                <div x-data="{ open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }" class="mt-5">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 rounded-md transition-colors duration-300 transform 
                        {{ request()->routeIs('admin.users.*') 
                            ? 'bg-emerald-500 dark:bg-indigo-600 text-white' 
                            : 'text-gray-200 hover:bg-slate-600 dark:hover:bg-gray-700 hover:text-gray-100' }}">

                        <div class="flex items-center">
                            <i class="fas fa-users-cog w-5 h-5"></i>
                            <span class="mx-4 font-medium">Usuários</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms class="mt-2 ml-4 space-y-2">
                        <a href="{{ route('admin.users.create') }}"
                            class="block px-4 py-2 rounded-md text-sm {{ request()->routeIs('admin.users.create') ? 'text-emerald-300 dark:text-indigo-300 font-bold' : 'text-gray-300 hover:text-white' }}">
                            Cadastrar Usuário
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="block px-4 py-2 rounded-md text-sm {{ request()->routeIs('admin.users.index') ? 'text-emerald-300 dark:text-indigo-300 font-bold' : 'text-gray-300 hover:text-white' }}">
                            Consultar Usuários
                        </a>
                    </div>
                </div>


                {{-- =============================================== --}}
                {{-- MENU DROPDOWN PARA AGENDAMENTOS --}}
                {{-- =============================================== --}}
                <div x-data="{ open: {{ request()->routeIs('admin.appointments.*') ? 'true' : 'false' }} }"
                    class="mt-5">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 rounded-md transition-colors duration-300 transform 
                        {{ request()->routeIs('admin.appointments.*') 
                            ? 'bg-emerald-500 dark:bg-indigo-600 text-white' 
                            : 'text-gray-200 hover:bg-slate-600 dark:hover:bg-gray-700 hover:text-gray-100' }}">

                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt w-5 h-5"></i>
                            <span class="mx-4 font-medium">Agendamentos</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms class="mt-2 ml-4 space-y-2">
                        <a href="{{ route('admin.appointments.index') }}"
                            class="block px-4 py-2 rounded-md text-sm {{ request()->routeIs('admin.appointments.index') ? 'text-emerald-300 dark:text-indigo-300 font-bold' : 'text-gray-300 hover:text-white' }}">
                            Consultar Agendamentos
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>