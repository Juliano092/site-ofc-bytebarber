<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(['id', 'name', 'email', 'user_type']);

        $this->info('Usuários no banco de dados:');
        $this->table(
            ['ID', 'Nome', 'Email', 'Tipo'],
            $users->map(function ($user) {
                return [$user->id, $user->name, $user->email, $user->user_type];
            })->toArray()
        );

        return 0;
    }
}
