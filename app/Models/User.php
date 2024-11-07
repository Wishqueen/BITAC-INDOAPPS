<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */



    // salah satu contoh access modifier (encapsulation -> protected)
    // access modifier (protected, private, public, etc..)
    protected $fillable = [
        'name',
        'gender',
        'address',
        'email',
        'phone',
        'date_of_birth',
        'image',
        'email_verified_at',
        'password',
        'course_id',
        'role',

    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function courses()
    {
        // This assumes each student can have multiple courses through the students table
        return $this->hasManyThrough(Course::class, Student::class, 'user_id', 'id', 'id', 'course_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    // Relasi ke TransactionItem
    public function transactionItems()
    {
        return $this->hasManyThrough(TransactionItem::class, Transaction::class);
    }
}
