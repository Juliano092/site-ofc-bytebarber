<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Removemos a constraint existente
        DB::statement("ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_status_check");

        // Modificamos a coluna para incluir os novos valores
        DB::statement("ALTER TABLE appointments ALTER COLUMN status TYPE VARCHAR(20)");

        // Adicionamos a nova constraint com todos os valores
        DB::statement("ALTER TABLE appointments ADD CONSTRAINT appointments_status_check CHECK (status IN ('pending', 'scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rejected', 'no_show'))");

        // Alteramos o valor padrão
        DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a constraint atual
        DB::statement("ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_status_check");

        // Restaura a constraint original
        DB::statement("ALTER TABLE appointments ADD CONSTRAINT appointments_status_check CHECK (status IN ('scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show'))");

        // Restaura o valor padrão original
        DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'scheduled'");
    }
};
