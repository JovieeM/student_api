<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // GET: Display all students
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    // POST: Create a student
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number',
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|unique:students,email',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully.',
            'data' => $student
        ], 201);
    }

    // GET: Display one student
    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        return response()->json($student, 200);
    }

    // PUT: Update a student
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        $validated = $request->validate([
            'student_number' => 'required|string|max:50|unique:students,student_number,' . $id,
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|unique:students,email,' . $id,
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $student
        ], 200);
    }

    // DELETE: Delete a student
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found.'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.'
        ], 200);
    }
}
