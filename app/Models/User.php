<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'date_birth',
        'cpf',
        'password',
        'plan_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        "updated_at",
        "created_at",

    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
