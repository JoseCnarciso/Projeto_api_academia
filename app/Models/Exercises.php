<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id'
       ];

       protected $hidden = [
        "updated_at",
        "created_at"
    ];
}
