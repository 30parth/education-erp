<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeachersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Teacher::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Staff ID',
            'Name',
            'Role',
            'Date of Joining',
            'Email',
            'Mobile Number',
            'Gender',
            'Date of Birth',
            'Qualification',
            'Work Experience',
            'PAN Number',
            'Father Name',
            'Address',
            'Note',
        ];
    }

    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->staff_id,
            $teacher->name,
            $teacher->role,
            $teacher->date_of_joining,
            $teacher->email,
            $teacher->mobile_number,
            $teacher->gender,
            $teacher->date_of_birth,
            $teacher->qualification,
            $teacher->work_experience,
            $teacher->pan_number,
            $teacher->father_name,
            $teacher->address,
            $teacher->note,
        ];
    }
}
