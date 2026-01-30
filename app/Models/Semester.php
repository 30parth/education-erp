<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'semester_name',
        'semester_code',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
