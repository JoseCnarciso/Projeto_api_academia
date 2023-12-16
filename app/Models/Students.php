<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'date_birth',
        'cpf',
        'contact',
        'cep',
        'street',
        'state',
        'neighborhood',
        'city',
        'number',
        'user_id'
       ];
    protected $hidden = [
        "updated_at",
        "created_at",

    ];
}
