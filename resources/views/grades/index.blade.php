@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold text-primary">🎓 Student Grades Management</h2>
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <a href="{{ route('grades.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Grade
            </a>
        </div>
    </div>
    <form method="POST" action="{{ route('grades.search') }}" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="student_id" class="form-control"
                       placeholder="Search by Student ID" value="{{ request('student_id') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('grades.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-refresh"></i> Reset
                </a>
            </div>
        </div>
    </form>
    @if($grades->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle text-center shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Student ID</th>
                    <th>Semester</th>
                    <th>Marks</th>
                    <th>CH</th>
                    <th>Status</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr data-id="{{ $grade->id }}">
                    <td class="fw-bold text-primary">{{ $grade->student_id }}</td>
                    <td contenteditable="true" class="editable bg-light" data-name="semester">{{ $grade->semester }}</td>
                    <td contenteditable="true" class="editable bg-light" data-name="marks">{{ $grade->marks }}</td>
                    <td contenteditable="true" class="editable bg-light" data-name="CH">{{ $grade->CH }}</td>
                    <td contenteditable="true" class="editable bg-light" data-name="status">{{ $grade->status }}</td>
                    <td>
                        <select class="form-select course-select" data-name="course_id">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $grade->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->code }} - {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="d-flex gap-1 justify-content-center">
                        <button class="btn btn-success btn-sm save-btn">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure to delete this grade?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle fa-2x mb-2"></i>
        <h4>No Grade Records Found</h4>
        <p>Try adjusting your search criteria or add new grade records.</p>
    </div>
    @endif
</div>
<script>
$(document).ready(function() {
    $('.save-btn').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        let data = {};

        row.find('.editable').each(function () {
            const name = $(this).data('name');
            const value = $(this).text().trim();
            data[name] = value;
        });

        data['course_id'] = row.find('.course-select').val();

        $.ajax({
            url: '{{ url('grades/update') }}/' + id,
            method: 'POST',
            data: {
                ...data,
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                alert('✅ Grade updated successfully!');
            },
            error: function (xhr) {
                alert('❌ Error updating grade.');
            }
        });
    });
});
</script>
@endsection
