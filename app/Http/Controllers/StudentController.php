<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicSession;
use App\Models\Program;

class StudentController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::all();
        $programs = Program::all();

        return view('students.student', compact('sessions', 'programs'));
    }

    public function filter(Request $request)
    {
        $query = Student::with(['session', 'program']);

        if ($request->session_id) {
            $query->where('session_id', $request->session_id);
        }

        if ($request->program_id) {
            $query->where('program_id', $request->program_id);
        }

        $students = $query->get();

        return view('students.data', compact('students'));
    }
}