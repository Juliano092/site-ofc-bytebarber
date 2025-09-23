<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barbershop;
use App\Models\Barber;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class BarbershopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar barbearia exemplo
        $barbershop = Barbershop::create([
            'name' => 'ByteBarber - Barbearia Premium',
            'email' => 'contato@bytebarber.com',
            'phone' => '(11) 99999-9999',
            'address' => 'Rua das Navalhas, 123',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '01234-567',
            'description' => 'A melhor barbearia da região com profissionais experientes e ambiente moderno.',
            'business_hours' => [
                'monday' => ['open' => '09:00', 'close' => '18:00'],
                'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                'thursday' => ['open' => '09:00', 'close' => '18:00'],
                'friday' => ['open' => '09:00', 'close' => '19:00'],
                'saturday' => ['open' => '08:00', 'close' => '17:00'],
                'sunday' => ['closed' => true]
            ]
        ]);

        // Criar usuário admin
        $admin = User::create([
            'name' => 'Admin ByteBarber',
            'email' => 'admin@bytebarber.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'phone' => '(11) 99999-9998',
            'barbershop_id' => $barbershop->id,
        ]);

        // Criar usuários barbeiros
        $barber1User = User::create([
            'name' => 'Carlos Silva',
            'email' => 'carlos@bytebarber.com',
            'password' => Hash::make('password'),
            'user_type' => 'barber',
            'phone' => '(11) 98888-8888',
            'barbershop_id' => $barbershop->id,
        ]);

        $barber2User = User::create([
            'name' => 'João Santos',
            'email' => 'joao@bytebarber.com',
            'password' => Hash::make('password'),
            'user_type' => 'barber',
            'phone' => '(11) 97777-7777',
            'barbershop_id' => $barbershop->id,
        ]);

        // Criar perfis de barbeiros
        $barber1 = Barber::create([
            'user_id' => $barber1User->id,
            'barbershop_id' => $barbershop->id,
            'bio' => 'Especialista em cortes clássicos e modernos com mais de 10 anos de experiência.',
            'working_hours' => [
                'monday' => ['start' => '09:00', 'end' => '18:00'],
                'tuesday' => ['start' => '09:00', 'end' => '18:00'],
                'wednesday' => ['start' => '09:00', 'end' => '18:00'],
                'thursday' => ['start' => '09:00', 'end' => '18:00'],
                'friday' => ['start' => '09:00', 'end' => '19:00'],
                'saturday' => ['start' => '08:00', 'end' => '17:00'],
            ],
            'commission_rate' => 40.00,
        ]);

        $barber2 = Barber::create([
            'user_id' => $barber2User->id,
            'barbershop_id' => $barbershop->id,
            'bio' => 'Expert em barbas e bigodes, atendimento personalizado e técnicas tradicionais.',
            'working_hours' => [
                'tuesday' => ['start' => '10:00', 'end' => '19:00'],
                'wednesday' => ['start' => '10:00', 'end' => '19:00'],
                'thursday' => ['start' => '10:00', 'end' => '19:00'],
                'friday' => ['start' => '10:00', 'end' => '20:00'],
                'saturday' => ['start' => '09:00', 'end' => '18:00'],
                'sunday' => ['start' => '10:00', 'end' => '16:00'],
            ],
            'commission_rate' => 45.00,
        ]);

        // Criar serviços
        $services = [
            [
                'name' => 'Corte Masculino',
                'description' => 'Corte completo com acabamento',
                'price' => 35.00,
                'duration' => 30,
            ],
            [
                'name' => 'Barba Completa',
                'description' => 'Barba com navalha e hidratação',
                'price' => 25.00,
                'duration' => 20,
            ],
            [
                'name' => 'Corte + Barba',
                'description' => 'Pacote completo com corte e barba',
                'price' => 55.00,
                'duration' => 45,
            ],
            [
                'name' => 'Bigode',
                'description' => 'Aparar e modelar bigode',
                'price' => 15.00,
                'duration' => 15,
            ],
            [
                'name' => 'Relaxamento',
                'description' => 'Relaxamento capilar masculino',
                'price' => 80.00,
                'duration' => 90,
            ]
        ];

        foreach ($services as $serviceData) {
            Service::create(array_merge($serviceData, [
                'barbershop_id' => $barbershop->id
            ]));
        }

        // Criar clientes exemplo
        $clients = [
            [
                'name' => 'Pedro Oliveira',
                'email' => 'pedro@email.com',
                'phone' => '(11) 96666-6666',
            ],
            [
                'name' => 'Roberto Costa',
                'email' => 'roberto@email.com',
                'phone' => '(11) 95555-5555',
            ],
            [
                'name' => 'Marcos Lima',
                'email' => 'marcos@email.com',
                'phone' => '(11) 94444-4444',
            ]
        ];

        foreach ($clients as $clientData) {
            User::create(array_merge($clientData, [
                'password' => Hash::make('password'),
                'user_type' => 'client',
                'barbershop_id' => $barbershop->id,
            ]));
        }
    }
}
