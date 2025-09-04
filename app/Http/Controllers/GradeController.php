<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Course;

class GradeController extends Controller
{
    // 🔹 List all grades (NO pagination now)
    public function index()
    {
        $grades = Grade::with('course')
            ->orderBy('semester', 'asc')
            ->orderBy('student_id', 'asc')
            ->get(); // ✅ replaced paginate() with get()

        $courses = Course::all();

        return view('grades.index', compact('grades', 'courses'));
    }

    // 🔹 Search grades by student_id (NO pagination)
    public function search(Request $request)
    {
        $query = Grade::with('course');
        $courses = Course::all();

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        $grades = $query
            ->orderBy('semester', 'asc')
            ->orderBy('student_id', 'asc')
            ->get(); // ✅ replaced paginate() with get()

        return view('grades.index', compact('grades', 'courses'));
    }

    // 🔹 Show create form
    public function create()
    {
        $courses = Course::all();
        return view('grades.create', compact('courses'));
    }

    // 🔹 Store new grade
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:50',
            'semester'   => 'required|integer|min:1',
            'marks'      => 'required|numeric|min:0',
            'CH'         => 'required|numeric|min:0.5',
            'status'     => 'required|string|in:Pass,Fail,Incomplete',
            'course_id'  => 'required|exists:courses,id',
        ]);

        Grade::create($validated);

        return redirect()->route('grades.index')
            ->with('success', '✅ Grade record created successfully.');
    }

    // 🔹 Update grade (AJAX inline editing)
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $grade->update($request->only([
            'semester', 'marks', 'CH', 'status', 'course_id'
        ]));

        return response()->json(['success' => true, 'message' => '✅ Grade updated successfully.']);
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', '🗑️ Grade record deleted successfully.');
    }
}
