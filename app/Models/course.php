<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    protected $table = 'courses';
    protected $fillable = [
        'title',
            'price',
            'duration',
            'instructor',
            'students',
            'image',
            'description',
    ] ;
}
