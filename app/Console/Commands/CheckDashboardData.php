<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Barbershop;
use App\Models\Service;
use App\Models\Barber;
use App\Models\Appointment;

class CheckDashboardData extends Command
{
    protected $signature = 'dashboard:check-data';
    protected $description = 'Verificar dados necessários para o dashboard';

    public function handle()
    {
        $this->info('Verificando dados do dashboard...');

        // Verificar admin
        $admin = User::where('email', 'admin@bytebarber.com')->first();
        $this->line('Admin encontrado: ' . ($admin ? '✅' : '❌'));

        if ($admin) {
            $this->line('Admin barbershop_id: ' . $admin->barbershop_id);

            // Verificar barbershop
            $barbershop = $admin->barbershop;
            $this->line('Barbershop encontrada: ' . ($barbershop ? '✅' : '❌'));

            if ($barbershop) {
                $this->line('Barbershop nome: ' . $barbershop->name);
                $this->line('Barbershop ID: ' . $barbershop->id);
            }
        }

        // Contar registros
        $this->line('');
        $this->line('Contagem de registros:');
        $this->line('Barbershops: ' . Barbershop::count());
        $this->line('Users: ' . User::count());
        $this->line('Services: ' . Service::count());
        $this->line('Barbers: ' . Barber::count());
        $this->line('Appointments: ' . Appointment::count());
    }
}
