<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'semester_id',
        'subject_name',
        'subject_code',
        'status',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
