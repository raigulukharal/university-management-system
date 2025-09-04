@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Add New Grade Record</h4>
                    <a href="{{ route('grades.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>⚠ Please fix the following issues:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('grades.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Student ID</label>
                                <input type="text" 
                                       name="student_id" 
                                       class="form-control @error('student_id') is-invalid @enderror" 
                                       value="{{ old('student_id') }}" 
                                       required>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Semester</label>
                                <input type="number" 
                                       name="semester" 
                                       class="form-control @error('semester') is-invalid @enderror" 
                                       value="{{ old('semester') }}" 
                                       required>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Marks</label>
                                <input type="number" step="0.01" 
                                       name="marks" 
                                       class="form-control @error('marks') is-invalid @enderror" 
                                       value="{{ old('marks') }}" 
                                       required>
                                @error('marks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Credit Hours (CH)</label>
                                <input type="number" step="0.5" 
                                       name="CH" 
                                       class="form-control @error('CH') is-invalid @enderror" 
                                       value="{{ old('CH') }}" 
                                       required>
                                @error('CH')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" 
                                        class="form-select @error('status') is-invalid @enderror" 
                                        required>
                                    <option value="">Select Status</option>
                                    <option value="Pass" {{ old('status') == 'Pass' ? 'selected' : '' }}>Pass</option>
                                    <option value="Fail" {{ old('status') == 'Fail' ? 'selected' : '' }}>Fail</option>
                                    <option value="Incomplete" {{ old('status') == 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course</label>
                                <select name="course_id" 
                                        class="form-select @error('course_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->code }} - {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('grades.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Grade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
