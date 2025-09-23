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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barbershop_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['percentage', 'fixed_amount', 'free_service']);
            $table->decimal('discount_value', 8, 2);
            $table->string('code')->unique()->nullable(); // código do cupom
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
