<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Informa ao Laravel que a tabela para este modelo é 'users'.
     */
    protected $table = 'users';

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'preferences',
        'avatar',
        'barbershop_id',
        'active'
    ];

    /**
     * Os atributos que devem ser escondidos.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pega a senha para o usuário.
     * Laravel usa a coluna 'password' por padrão
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password; // Usa a coluna 'password' da tabela
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean'
        ];
    }

    /**
     * Relacionamento com Barbershop
     */
    public function barbershop()
    {
        return $this->belongsTo(Barbershop::class);
    }

    /**
     * Relacionamento com Barber (quando o usuário é barbeiro)
     */
    public function barber()
    {
        return $this->hasOne(Barber::class);
    }
}
