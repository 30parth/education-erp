<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\TeachersExport;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function export()
    {
        return Excel::download(new TeachersExport, 'teachers.xlsx');
    }
}
