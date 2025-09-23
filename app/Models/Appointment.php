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
        'completed_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'checked_in_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'reference_images' => 'array',
        'price' => 'decimal:2'
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
}
