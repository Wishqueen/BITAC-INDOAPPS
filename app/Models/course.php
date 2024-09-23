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
    public function learningMaterials()
    {
        return $this->hasMany(learning_materials::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function certifications()
{
    return $this->hasMany(Certification::class);
}

public function user()
{
    return $this->belongsToMany(User::class);
}
public function students()
{
    return $this->hasMany(Student::class);
}

}
