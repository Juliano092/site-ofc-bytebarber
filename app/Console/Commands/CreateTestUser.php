<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for login testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Criar usuário cliente de teste
        $user = User::create([
            'name' => 'Teste Cliente',
            'email' => 'teste@email.com',
            'password' => Hash::make('123456'),
            'user_type' => 'client',
            'phone' => '(11) 99999-9999',
            'barbershop_id' => 1,
        ]);

        $this->info('Usuário de teste criado:');
        $this->info('Email: teste@email.com');
        $this->info('Senha: 123456');
        $this->info('Tipo: client');

        return 0;
    }
}
