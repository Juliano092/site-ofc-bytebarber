<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'barbershop_id',
        'name',
        'description',
        'price',
        'duration',
        'image',
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean'
    ];

    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }

    public function barbers()
    {
        return $this->belongsToMany(Barber::class, 'barber_services');
    }
}
