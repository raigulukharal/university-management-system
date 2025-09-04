<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResultsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('results')->truncate();

        $sessions = ['2022', '2023', '2024'];
        $subjects = ['Math', 'Physics', 'Chemistry', 'Biology', 'Computer'];
        
        // Pakistani names list
        $names = [
            'Ali', 'Ahmed', 'Hassan', 'Hussain', 'Fatima', 'Ayesha', 'Sana', 'Bilal',
            'Hamza', 'Usman', 'Zain', 'Abdullah', 'Maryam', 'Noor', 'Iqra', 'Zara',
            'Saad', 'Kashif', 'Nida', 'Hira', 'Imran', 'Shahzaib', 'Waleed', 'Mahnoor',
            'Dua', 'Laiba', 'Sadia', 'Rida', 'Asad', 'Fahad', 'Anum', 'Sobia'
        ];

        $rollCounter = 1;

        foreach ($sessions as $session) {
            for ($i = 1; $i <= 30; $i++) { // 30 students per session
                $rollNo = 'ST' . str_pad($rollCounter, 3, '0', STR_PAD_LEFT);
                $studentName = $names[array_rand($names)];

                foreach ($subjects as $subject) {
                    $marks = rand(40, 95);
                    $creditHour = rand(2, 4);

                    // GP calculation
                    if ($marks >= 90) $gp = 4.0;
                    elseif ($marks >= 85) $gp = 3.7;
                    elseif ($marks >= 80) $gp = 3.3;
                    elseif ($marks >= 75) $gp = 3.0;
                    elseif ($marks >= 70) $gp = 2.7;
                    elseif ($marks >= 65) $gp = 2.3;
                    elseif ($marks >= 60) $gp = 2.0;
                    elseif ($marks >= 55) $gp = 1.7;
                    elseif ($marks >= 50) $gp = 1.0;
                    else $gp = 0.0;

                    $gpa = $gp * $creditHour;

                    DB::table('results')->insert([
                        'roll_no' => $rollNo,
                        'student_name' => $studentName,
                        'course_name' => $subject,
                        'obtained_mark' => $marks,
                        'credit_hour' => $creditHour,
                        'gp' => $gp,
                        'gpa' => $gpa,
                        'session_id' => $session,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $rollCounter++;
            }
        }
    }
}
