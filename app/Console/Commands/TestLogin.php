<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TestLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login:test {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test login credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->info("Testando login para: {$email}");

        // Encontrar usuário
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('Usuário não encontrado!');
            return 1;
        }

        $this->info("Usuário encontrado: {$user->name}");
        $this->info("Tipo: {$user->user_type}");
        $this->info("ID: {$user->id}");

        // Testar senha
        if (Hash::check($password, $user->password)) {
            $this->info('✅ Senha correta!');
        } else {
            $this->error('❌ Senha incorreta!');
            return 1;
        }

        // Testar Auth::attempt com debug
        $this->info('Testando Auth::attempt...');

        try {
            // Vamos testar com diferentes guards e providers
            $this->info('Testando com guard padrão...');
            $result1 = Auth::attempt(['email' => $email, 'password' => $password]);
            $this->info('Resultado Auth::attempt: ' . ($result1 ? 'true' : 'false'));

            $this->info('Testando com guard web explícito...');
            $result2 = Auth::guard('web')->attempt(['email' => $email, 'password' => $password]);
            $this->info('Resultado Auth::guard(web)->attempt: ' . ($result2 ? 'true' : 'false'));

            // Testar manualmente
            $this->info('Testando autenticação manual...');
            $provider = Auth::createUserProvider('users');
            $userByCredentials = $provider->retrieveByCredentials(['email' => $email]);

            if ($userByCredentials) {
                $this->info('Provider encontrou usuário: ' . $userByCredentials->name);
                $validateCredentials = $provider->validateCredentials($userByCredentials, ['password' => $password]);
                $this->info('Validação de credenciais: ' . ($validateCredentials ? 'true' : 'false'));
            } else {
                $this->error('Provider NÃO encontrou usuário');
            }

        } catch (\Exception $e) {
            $this->error('Erro durante Auth::attempt: ' . $e->getMessage());
        }

        return 0;
    }
}
