<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    protected $fillable = [
        'semester_id',
        'division_id',
        'subject_id',
        'teacher_id',
        'lecture_code',
        'day',
        'start_time',
        'end_time'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
