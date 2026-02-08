<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'username' => $row['admission_no'],
            'password' => Hash::make($row['admission_no']),
            'role'     => 'student',
        ]);

        return new Student([
            'user_id' => $user->id,
            'admission_no' => $row['admission_no'],
            'roll_number' => $row['roll_number'],
            'semester_id' => \App\Models\Semester::where('name', $row['semester'])->first()->id,
            'division_id' => \App\Models\Division::where('name', $row['division'])->first()->id,
            'admission_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['admission_date']),
            'category' => $row['category'],
            'name' => $row['name'],
            'gender' => $row['gender'],
            'date_of_birth' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth']),
            'blood_group' => $row['blood_group'],
            'mobile_number' => $row['mobile_number'],
            'email' => $row['email'],
            'medical_history' => $row['medical_history'],
        ]);
    }
}
