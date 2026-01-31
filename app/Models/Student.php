<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'admission_no',
        'roll_number',
        'semester_id',
        'section',
        'admission_date',
        'category',
        'name',
        'gender',
        'date_of_birth',
        'blood_group',
        'mobile_number',
        'email',
        'medical_history',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
