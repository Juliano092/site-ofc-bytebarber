<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:fix-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix admin password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin = User::where('email', 'admin@bytebarber.com')->first();

        if (!$admin) {
            $this->error('Admin não encontrado!');
            return 1;
        }

        $this->info('Admin encontrado: ' . $admin->name);
        $this->info('Hash atual: ' . $admin->password);

        // Gerar novo hash
        $newPassword = 'password';
        $newHash = Hash::make($newPassword);

        $this->info('Novo hash: ' . $newHash);

        // Verificar se o novo hash funciona
        if (Hash::check($newPassword, $newHash)) {
            $this->info('✅ Novo hash válido');
        } else {
            $this->error('❌ Novo hash inválido');
            return 1;
        }

        // Atualizar no banco
        $admin->password = $newHash;
        $admin->save();

        $this->info('✅ Senha do admin atualizada!');

        // Testar novamente
        if (Hash::check($newPassword, $admin->fresh()->password)) {
            $this->info('✅ Verificação final OK');
        } else {
            $this->error('❌ Verificação final falhou');
        }

        return 0;
    }
}
