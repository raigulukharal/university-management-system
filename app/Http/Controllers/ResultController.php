<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $sessions = Result::select('session_id')
            ->distinct()
            ->orderBy('session_id', 'asc')
            ->pluck('session_id');
        $selectedSession = $request->get('session', $sessions->last());
        $stats = $this->calculateSessionStats($selectedSession);
        
        return view('results.index', compact('sessions', 'selectedSession', 'stats'));
    }

    public function data(Request $request)
    {
        $search = $request->get('search', '');
        $session = $request->get('session', '2024');
        $query = DB::table('results')->where('session_id', $session);
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%$search%")
                  ->orWhere('roll_no', 'like', "%$search%");
            });
        }
        $results = $query->orderBy('roll_no')
                        ->orderBy('course_name')
                        ->get();
        $subjects = DB::table('results')
            ->select('course_name')
            ->where('session_id', $session)
            ->distinct()
            ->orderBy('course_name')
            ->get();
        $sessions = Result::select('session_id')
            ->distinct()
            ->orderBy('session_id', 'asc')
            ->pluck('session_id');
        $students = [];
        foreach($results as $res) {
            if (!isset($students[$res->roll_no])) {
                $students[$res->roll_no] = [
                    'info' => $res,
                    'subjects' => [],
                    'total_credits' => 0,
                    'total_gpa' => 0,
                    'status' => 'Pass'
                ];
            }
            $students[$res->roll_no]['subjects'][$res->course_name] = $res;
            $students[$res->roll_no]['total_credits'] += $res->credit_hour;
            $students[$res->roll_no]['total_gpa'] += $res->gpa;
        }
        foreach($students as $roll_no => &$studentData) {
            $studentData['cgpa'] = $studentData['total_credits'] > 0 
                ? $studentData['total_gpa'] / $studentData['total_credits'] 
                : 0;
            if ($studentData['cgpa'] < 2.1) {
                $studentData['status'] = 'Dropped';
            }
        }
        $stats = $this->calculateSessionStats($session);

        return view('results.data', compact('results', 'subjects', 'sessions', 'session', 'students', 'stats'));
    }

    public function update(Request $request, $id)
    {
        $result = Result::findOrFail($id);

        $request->validate([
            'obtained_mark' => 'nullable|numeric|min:0|max:100'
        ]);

        $mark = (float) $request->input('obtained_mark', $result->obtained_mark);
        if ($mark >= 90) $gp = 4.0;
        elseif ($mark >= 85) $gp = 3.7;
        elseif ($mark >= 80) $gp = 3.3;
        elseif ($mark >= 75) $gp = 3.0;
        elseif ($mark >= 70) $gp = 2.7;
        elseif ($mark >= 65) $gp = 2.3;
        elseif ($mark >= 60) $gp = 2.0;
        elseif ($mark >= 55) $gp = 1.7;
        elseif ($mark >= 50) $gp = 1.0;
        else $gp = 0.0;

        $gpa = $gp * $result->credit_hour;
        $result->update([
            'obtained_mark' => $mark,
            'gp' => $gp,
            'gpa' => $gpa
        ]);
        $studentResults = Result::where('roll_no', $result->roll_no)
            ->where('session_id', $result->session_id)
            ->get();

        $totalCredits = 0;
        $totalGPA = 0;
        
        foreach($studentResults as $res) {
            $totalCredits += $res->credit_hour;
            $totalGPA += $res->gpa;
        }
        
        $cgpa = $totalCredits > 0 ? $totalGPA / $totalCredits : 0;
        $status = $cgpa >= 2.1 ? 'Pass' : 'Dropped';
        $stats = $this->calculateSessionStats($result->session_id);

        return response()->json([
            'success' => true,
            'gp' => $gp,
            'gpa' => $gpa,
            'grade' => $this->getGrade($mark, 50),
            'cgpa' => $cgpa,
            'status' => $status,
            'stats' => $stats 
        ]);
    }

    private function getGrade($marks, $passMarks = 40)
    {
        $marks = (float) $marks;

        if ($marks < $passMarks) {
            return "F";
        } elseif ($marks >= 90) {
            return "A+";
        } elseif ($marks >= 80) {
            return "A";
        } elseif ($marks >= 70) {
            return "B";
        } elseif ($marks >= 60) {
            return "C";
        } elseif ($marks >= 50) {
            return "D";
        } elseif ($marks >= $passMarks) {
            return "E";
        }
        return "F";
    }

    private function calculateSessionStats($session)
    {
        // Get all results for the session
        $results = Result::where('session_id', $session)->get();
        
        // Group by student
        $students = [];
        foreach($results as $res) {
            if (!isset($students[$res->roll_no])) {
                $students[$res->roll_no] = [
                    'total_credits' => 0,
                    'total_gpa' => 0,
                    'subjects' => []
                ];
            }
            $students[$res->roll_no]['subjects'][] = $res;
            $students[$res->roll_no]['total_credits'] += $res->credit_hour;
            $students[$res->roll_no]['total_gpa'] += $res->gpa;
        }
        $failCount = 0;
        $lessThan3 = 0;
        $greaterThan3 = 0;
        $totalGPA = 0;
        $totalCredits = 0;
        
        foreach($students as $roll_no => $data) {
            $cgpa = $data['total_credits'] > 0 
                ? $data['total_gpa'] / $data['total_credits'] 
                : 0;
                
            if ($cgpa < 2.1) {
                $failCount++;
            } elseif ($cgpa < 3.0) {
                $lessThan3++;
            } else {
                $greaterThan3++;
            }
            $totalGPA += $data['total_gpa'];
            $totalCredits += $data['total_credits'];
        }
        
        $sessionGpa = $totalCredits > 0 ? $totalGPA / $totalCredits : 0;
        
        return [
            'total_students' => count($students),
            'fail_count' => $failCount,
            'less_than_3' => $lessThan3,
            'greater_than_3' => $greaterThan3,
            'session_gpa' => $sessionGpa
        ];
    }
    public function resetData(Request $request)
{
    try {
        DB::table('results')->truncate();
        DB::table('results')->insertUsing([
            'roll_no', 'student_name', 'course_name', 'obtained_mark', 
            'credit_hour', 'gp', 'gpa', 'session_id'
        ], function ($query) {
            $query->select('roll_no', 'student_name', 'course_name', 'obtained_mark', 
                          'credit_hour', 'gp', 'gpa', 'session_id')
                  ->from('master_results');
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Data reset successfully from masters table'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error resetting data: ' . $e->getMessage()
        ], 500);
    }
}

public function checkMasterData()
{
    $count = DB::table('master_results')->count();
    return response()->json(['has_data' => $count > 0]);
}
}
