<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Barbershop;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PRIMEIRO: Busca a primeira barbearia que existe ou cria uma nova.
        // Isso garante que $barbershop sempre terá um valor.
        $barbershop = Barbershop::firstOrCreate(
            ['name' => 'Byte Barber Unidade Central'],
            ['email' => 'contato@bytebarber.com'] // Dados extras caso precise criar
        );

        // Apaga o usuário admin antigo para evitar duplicatas ao rodar o seeder várias vezes
        User::where('email', 'admin@bytebarber.com')->delete();

        // 2. SEGUNDO: Cria o usuário Administrador, agora com um $barbershop->id válido.
        User::create([
            'name' => 'Admin Byte Barber',
            'email' => 'admin@bytebarber.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'barbershop_id' => $barbershop->id,
        ]);
    }
}
