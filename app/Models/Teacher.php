<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'role',
        'date_of_joining',
        'pan_number',
        'name',
        'father_name',
        'gender',
        'date_of_birth',
        'qualification',
        'work_experience',
        'note',
        'email',
        'mobile_number',
        'address',
    ];

    public function timetables()
    {
        return $this->hasMany(TimeTable::class);
    }
}
