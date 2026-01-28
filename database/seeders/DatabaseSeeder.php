<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'username' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Teacher
        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'username' => 'teacher@example.com',
            'role' => 'teacher',
        ]);

        // Student
        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'username' => '216920307012',
            'role' => 'student',
        ]);
    }
}
