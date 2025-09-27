<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome_cliente',
        'nome_barbearia',
        'email',
        'cpf',
        'telefone',
        'bairro',
        'cep',
        'status',
    ];
}
