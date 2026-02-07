<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::with(['semester', 'division'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Admission No',
            'Roll Number',
            'Name',
            'Email',
            'Mobile Number',
            'Gender',
            'Date of Birth',
            'Semester',
            'Division',
            'Admission Date',
            'Category',
            'Blood Group',
            'Medical History',
        ];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->admission_no,
            $student->roll_number,
            $student->name,
            $student->email,
            $student->mobile_number,
            $student->gender,
            $student->date_of_birth,
            $student->semester ? $student->semester->semester_name : 'N/A',
            $student->division ? $student->division->division_name : 'N/A',
            $student->admission_date,
            $student->category,
            $student->blood_group,
            $student->medical_history,
        ];
    }
}
