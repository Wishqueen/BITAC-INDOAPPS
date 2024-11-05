<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory; // Menggunakan trait HasFactory

    protected $table = 'courses'; // Mendefinisikan nama tabel yang digunakan

    protected $fillable = [ // Mendefinisikan kolom yang dapat diisi secara massal
        'title',
        'price',
        'discount', 
        'discounted_price',
        'duration',
        'instructor',
        'students',
        'image',
        'description',
    ];

    // Relasi ke model LearningMaterial
    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class); // Mengindikasikan bahwa satu course bisa memiliki banyak learning materials
    }

    // Relasi ke model User
    public function users()
    {
        return $this->hasMany(User::class); // Mengindikasikan bahwa satu course bisa memiliki banyak users (seharusnya relasi ini lebih tepat sebagai belongsToMany)
    }

    // Relasi ke model Certification
    public function certifications()
    {
        return $this->hasMany(Certification::class); // Mengindikasikan bahwa satu course bisa memiliki banyak certifications
    }

    // Relasi many-to-many ke model User
    public function user()
    {
        return $this->belongsToMany(User::class); // Mengindikasikan bahwa satu course bisa diambil oleh banyak user
    }

    // Relasi ke model Student
    public function students()
    {
        return $this->hasMany(Student::class); // Mengindikasikan bahwa satu course bisa memiliki banyak students
    }

    // Relasi ke model Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class); // Mengindikasikan bahwa satu course bisa memiliki banyak transactions
    }

    // Relasi ke model TransactionItem
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class); // Mengindikasikan bahwa satu course bisa memiliki banyak transaction items
    }
}
