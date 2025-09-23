<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barbershop extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'description',
        'logo',
        'business_hours',
        'active'
    ];

    protected $casts = [
        'business_hours' => 'array',
        'active' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function barbers()
    {
        return $this->hasMany(Barber::class);
    }
}
