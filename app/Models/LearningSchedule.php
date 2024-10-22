<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'course_id',
        'material',
        'start_time',
         'end_time',
        'instructor_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo( User::class);
    }
}
