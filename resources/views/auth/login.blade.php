<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Byte Barber - Acesso</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'fundo': '#0a0a0a',
                        'dourado': '#FFD700',
                        'dourado-escuro': '#DAA520',
                        'texto-claro': '#f0f0f0',
                        'texto-cinza': '#a0a0a0',
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/login.css'])
</head>

<body class="bg-fundo">

    <ul class="background-animado">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div class="flex items-center justify-center min-h-screen">

        <div
            class="w-full max-w-md p-8 space-y-8 bg-black/60 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-800">

            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-white">
                    <span class="text-dourado">BYTE</span> BARBER
                </h1>
                <p class="mt-2 text-texto-cinza">Programando o seu melhor Visual</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Exibir erros de validação -->
                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-texto-cinza" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </span>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-texto-claro placeholder-texto-cinza focus:outline-none focus:ring-2 focus:ring-dourado focus:border-transparent"
                        placeholder="seu@email.com">
                </div>

                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-texto-cinza" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="w-full pl-10 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-texto-claro placeholder-texto-cinza focus:outline-none focus:ring-2 focus:ring-dourado focus:border-transparent"
                        placeholder="Sua senha">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-gray-600 bg-gray-800 text-dourado focus:ring-dourado">
                        <span class="ml-2 text-texto-cinza">Lembrar-me</span>
                    </label>
                    <a href="#" class="font-medium text-dourado hover:text-dourado-escuro">Esqueceu a senha?</a>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-black bg-dourado hover:bg-dourado-escuro focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dourado transition-all duration-300">
                        ENTRAR
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>