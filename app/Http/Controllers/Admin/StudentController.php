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
}
