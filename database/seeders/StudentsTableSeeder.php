<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\AcademicSession;
use App\Models\Program;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $sessions = AcademicSession::all();
        $programs = Program::all();
        
        $firstNames = ['Emma', 'Noah', 'Olivia', 'Liam', 'Ava', 'Lucas', 'Mia', 'Ethan', 'Isabella', 'James', 'Sophia', 'Alexander', 'Charlotte', 'Benjamin', 'Amelia', 'William', 'Harper', 'Michael', 'Evelyn', 'Daniel'];
        $lastNames = ['Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee'];
        
        for ($i = 0; $i < 2000; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            
            $cgpa = rand(150, 400) / 100; 
            $sessionId = $sessions->random()->id;
            $programId = $programs->random()->id;
            
            Student::create([
                'name' => $name,
                'cgpa' => $cgpa,
                'session_id' => $sessionId,
                'program_id' => $programId,
            ]);
        }
    }
}