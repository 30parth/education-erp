<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'date',
        'lecture_code',
        'student_id',
        'status',
        'description',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
