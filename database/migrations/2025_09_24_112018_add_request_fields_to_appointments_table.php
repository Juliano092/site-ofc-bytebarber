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
        Schema::table('appointments', function (Blueprint $table) {
            // Campos para solicitação de cancelamento
            $table->boolean('cancellation_requested')->default(false);
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancellation_requested_at')->nullable();

            // Campos para solicitação de reagendamento
            $table->boolean('reschedule_requested')->default(false);
            $table->text('reschedule_reason')->nullable();
            $table->timestamp('reschedule_requested_at')->nullable();
            $table->timestamp('requested_new_datetime')->nullable();

            // Campo para tracking de alterações administrativas
            $table->text('admin_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'cancellation_requested',
                'cancellation_reason',
                'cancellation_requested_at',
                'reschedule_requested',
                'reschedule_reason',
                'reschedule_requested_at',
                'requested_new_datetime',
                'admin_notes'
            ]);
        });
    }
};
