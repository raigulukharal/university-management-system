<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicSession;

class AcademicSessionsTableSeeder extends Seeder
{
    public function run()
    {
        $sessions = [
            ['year' => '2022-2026'],
            ['year' => '2023-2027'],
            ['year' => '2024-2028'],
        ];

        foreach ($sessions as $session) {
            AcademicSession::create($session);
        }
    }
}