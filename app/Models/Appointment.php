<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'client_id',
        'barber_id',
        'service_id',
        'barbershop_id',
        'scheduled_at',
        'status',
        'price',
        'notes',
        'reference_images',
        'payment_method',
        'payment_status',
        'checked_in_at',
        'started_at',
        'completed_at',
        // Campos para solicitações
        'cancellation_requested',
        'cancellation_reason',
        'cancellation_requested_at',
        'reschedule_requested',
        'reschedule_reason',
        'reschedule_requested_at',
        'requested_new_datetime',
        'admin_notes'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancellation_requested_at' => 'datetime',
        'reschedule_requested_at' => 'datetime',
        'requested_new_datetime' => 'datetime',
        'reference_images' => 'array',
        'price' => 'decimal:2',
        'cancellation_requested' => 'boolean',
        'reschedule_requested' => 'boolean'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Status possíveis para agendamentos
     */
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pendente',
            'scheduled' => 'Agendado',
            'in_progress' => 'Em Andamento',
            'completed' => 'Concluído',
            'cancelled' => 'Cancelado',
            'rejected' => 'Rejeitado'
        ];
    }

    /**
     * Traduzir status para português
     */
    public function getStatusInPortugueseAttribute()
    {
        $statusOptions = self::getStatusOptions();
        return $statusOptions[$this->status] ?? $this->status;
    }

    /**
     * Verificar se agendamento está aprovado
     */
    public function isApproved()
    {
        return in_array($this->status, ['scheduled', 'in_progress', 'completed']);
    }

    /**
     * Verificar se agendamento está pendente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Aprovar agendamento
     */
    public function approve()
    {
        $this->update(['status' => 'scheduled']);
    }

    /**
     * Rejeitar agendamento
     */
    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    /**
     * Solicitar cancelamento
     */
    public function requestCancellation($reason = null)
    {
        $this->update([
            'cancellation_requested' => true,
            'cancellation_reason' => $reason,
            'cancellation_requested_at' => now()
        ]);
    }

    /**
     * Solicitar reagendamento
     */
    public function requestReschedule($newDateTime, $reason = null)
    {
        $this->update([
            'reschedule_requested' => true,
            'reschedule_reason' => $reason,
            'reschedule_requested_at' => now(),
            'requested_new_datetime' => $newDateTime
        ]);
    }

    /**
     * Verificar se tem solicitação de cancelamento pendente
     */
    public function hasCancellationRequest()
    {
        return $this->cancellation_requested && $this->status !== 'cancelled';
    }

    /**
     * Verificar se tem solicitação de reagendamento pendente
     */
    public function hasRescheduleRequest()
    {
        return $this->reschedule_requested && $this->status !== 'cancelled';
    }

    /**
     * Aprovar solicitação de cancelamento
     */
    public function approveCancellation($adminNotes = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_requested' => false,
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * Negar solicitação de cancelamento
     */
    public function denyCancellation($adminNotes = null)
    {
        $this->update([
            'cancellation_requested' => false,
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * Aprovar solicitação de reagendamento
     */
    public function approveReschedule($adminNotes = null)
    {
        $this->update([
            'scheduled_at' => $this->requested_new_datetime,
            'reschedule_requested' => false,
            'requested_new_datetime' => null,
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * Negar solicitação de reagendamento
     */
    public function denyReschedule($adminNotes = null)
    {
        $this->update([
            'reschedule_requested' => false,
            'requested_new_datetime' => null,
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * Verificar se pode ser cancelado/reagendado pelo cliente
     */
    public function canBeModifiedByClient()
    {
        // Só permite modificação se o agendamento não está em andamento, completo ou já cancelado
        // E se é no futuro (pelo menos 2 horas de antecedência)
        return in_array($this->status, ['pending', 'scheduled']) &&
            $this->scheduled_at->greaterThan(now()->addHours(2));
    }
}
