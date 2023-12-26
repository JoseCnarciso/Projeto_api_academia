<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function workouts()
    {
        return $this->hasMany(Workout::class, 'student_id');
    }


}
