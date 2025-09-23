<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    protected $fillable = [
        'user_id',
        'barbershop_id',
        'bio',
        'portfolio_images',
        'working_hours',
        'commission_rate',
        'private_notes',
        'accepts_new_clients'
    ];

    protected $casts = [
        'portfolio_images' => 'array',
        'working_hours' => 'array',
        'commission_rate' => 'decimal:2',
        'accepts_new_clients' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'barber_services');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
