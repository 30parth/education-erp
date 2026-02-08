<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function import()
    {
        request()->validate([
            'file' => 'required|mimes:xlsx,excel,csv',
        ]);

        Excel::import(new \App\Imports\StudentsImport, request()->file('file'));

        return back()->with('success', 'Students imported successfully.');
    }
}
