<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramsTableSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Zoology'],
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Physics'],
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Chemistry'],
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Botany'],
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Computer Science'],
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Information Technology'],
            ['faculty' => 'Faculty of Natural Science and Technology', 'department' => 'Mathematics'],
            ['faculty' => 'Faculty of Social & Behavioral Science', 'department' => 'Psychology'],
            ['faculty' => 'Faculty of Language and Liberal Arts', 'department' => 'Fine Arts'],
            ['faculty' => 'Faculty of Language and Liberal Arts', 'department' => 'Graphic Design'],
            ['faculty' => 'Faculty of Language and Liberal Arts', 'department' => 'Punjabi'],
            ['faculty' => 'Faculty of Language and Liberal Arts', 'department' => 'English Literature'],
            ['faculty' => 'Faculty of Management Sciences', 'department' => 'BBA'],
            ['faculty' => 'Faculty of Theology and Religion', 'department' => 'Islamic Studies'],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}