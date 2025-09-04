<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AcademicSessionsTableSeeder::class,
            ProgramsTableSeeder::class,
            StudentsTableSeeder::class,
            ResultsTableSeeder::class,
        ]);
    }
}
