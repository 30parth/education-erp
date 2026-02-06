<?php

namespace Tests\Feature\Student;

use App\Models\Attendance;
use App\Models\Division;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeTable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_weekly_timetable_and_attendance()
    {
        // 1. Setup Data
        $semester = Semester::create(['name' => 'Sem 1', 'status' => 'active', 'start_date' => now(), 'end_date' => now()->addMonths(6)]);
        $division = Division::create(['name' => 'A', 'status' => 'active']);
        
        $user = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $user->id,
            'semester_id' => $semester->id,
            'division_id' => $division->id,
            'admission_no' => '123',
            'roll_number' => '101',
            'name' => 'John Doe',
            'email' => $user->email,
        ]);

        $subject = Subject::create([
            'semester_id' => $semester->id,
            'subject_name' => 'Mathematics',
            'subject_code' => 'MATH101',
            'status' => 'active',
        ]);

        $teacher = Teacher::create([
            'name' => 'Dr. Smith',
            'email' => 'teacher@example.com',
            'staff_id' => 'T001',
        ]);

        // Current Week Dates
        $today = now()->startOfWeek(); 
        
        // 2. Create Timetable
        TimeTable::create([
            'semester_id' => $semester->id,
            'division_id' => $division->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'lecture_code' => 'MATH_MON_10',
            'day' => $today->format('l'),
            'start_time' => '10:00',
            'end_time' => '11:00',
        ]);

        // 3. Create Attendance (Present)
        Attendance::create([
            'student_id' => $student->id,
            'date' => $today->format('Y-m-d'),
            'lecture_code' => 'MATH_MON_10',
            'status' => 'Present',
        ]);

        // 4. Act & Assert
        $this->actingAs($user);

        $component = Livewire::test('student.dashboard');
        
        $component->assertSee('Mathematics')
            ->assertSee('Dr. Smith')
            ->assertSee('Present');
            
        // Check for Green Color (Present)
        $component->assertSee('bg-green-100');
    }

    public function test_student_can_view_absent_attendance()
    {
         // 1. Setup Data
         $semester = Semester::create(['name' => 'Sem 1', 'status' => 'active', 'start_date' => now(), 'end_date' => now()->addMonths(6)]);
         $division = Division::create(['name' => 'A', 'status' => 'active']);
         
         $user = User::factory()->create(['role' => 'student']);
         $student = Student::create([
             'user_id' => $user->id,
             'semester_id' => $semester->id,
             'division_id' => $division->id,
             'admission_no' => '123',
             'roll_number' => '101',
             'name' => 'Jane Doe',
             'email' => $user->email,
         ]);
 
         $subject = Subject::create([
             'semester_id' => $semester->id,
             'subject_name' => 'Physics',
             'subject_code' => 'PHY101',
             'status' => 'active',
         ]);
 
         $teacher = Teacher::create([
             'name' => 'Prof. Einstein',
             'email' => 'phy@example.com',
             'staff_id' => 'T002',
         ]);
 
         // Current Week Dates
         $today = now()->startOfWeek(); 
         
         // 2. Create Timetable
         TimeTable::create([
             'semester_id' => $semester->id,
             'division_id' => $division->id,
             'subject_id' => $subject->id,
             'teacher_id' => $teacher->id,
             'lecture_code' => 'PHY_MON_10',
             'day' => $today->format('l'),
             'start_time' => '10:00',
             'end_time' => '11:00',
         ]);
 
         // 3. Create Attendance (Absent)
         Attendance::create([
             'student_id' => $student->id,
             'date' => $today->format('Y-m-d'),
             'lecture_code' => 'PHY_MON_10',
             'status' => 'Absent',
         ]);
 
         // 4. Act & Assert
         $this->actingAs($user);
 
         $component = Livewire::test('student.dashboard');
         
         $component->assertSee('Physics')
             ->assertSee('Prof. Einstein')
             ->assertSee('Absent');
             
         // Check for Red Color (Absent)
         $component->assertSee('bg-red-100');
    }
}
