<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('barbershop_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->json('portfolio_images')->nullable(); // fotos dos trabalhos
            $table->json('working_hours'); // horários de trabalho
            $table->decimal('commission_rate', 5, 2)->default(0); // percentual de comissão
            $table->text('private_notes')->nullable(); // anotações privadas sobre clientes
            $table->boolean('accepts_new_clients')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barbers');
    }
};
