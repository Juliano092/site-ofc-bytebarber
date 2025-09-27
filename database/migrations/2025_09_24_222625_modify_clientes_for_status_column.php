<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // ESTA LINHA EXCLUI A COLUNA ANTIGA 'deleted_at'
            $table->dropSoftDeletes();

            // ESTA LINHA ADICIONA A NOVA COLUNA 'status'
            // Agora a coluna aceita apenas 1 caractere e o padrão é 'S'
            $table->string('status', 1)->default('S');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
};
