<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instructor extends Model
{
    use HasFactory;

    protected $fillable = [
       'name',
        'address',
        'phone',
       'email',
       'skills',
        'date_of_birth',
        'image',
        'cv',
        'status',
       'description'
    ];
}
