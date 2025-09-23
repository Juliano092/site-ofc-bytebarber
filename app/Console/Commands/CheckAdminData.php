<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckAdminData extends Command
{
    protected $signature = 'admin:check-data';
    protected $description = 'Verificar dados completos do usuário admin';

    public function handle()
    {
        $admin = User::where('email', 'admin@bytebarber.com')->first();

        if (!$admin) {
            $this->error('Admin não encontrado!');
            return;
        }

        $this->info('Dados do Admin:');
        $this->line('ID: ' . $admin->id);
        $this->line('Nome: ' . $admin->name);
        $this->line('Email: ' . $admin->email);
        $this->line('Tipo: ' . $admin->user_type);
        $this->line('Barbershop ID: ' . ($admin->barbershop_id ?? 'NULL'));
        $this->line('Phone: ' . ($admin->phone ?? 'NULL'));
        $this->line('Active: ' . ($admin->active ? 'true' : 'false'));

        // Verificar se há relação barbershop
        if ($admin->barbershop_id) {
            $this->line('Tem barbershop_id definido');
        } else {
            $this->warn('⚠️  Admin não tem barbershop_id definido');
        }
    }
}
