@if($students->count() > 0)
    <div class="table-responsive">
        <table class="students-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Session</th>
                    <th>Program</th>
                    <th>CGPA</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    @php
                        if ($student->cgpa >= 3.5) {
                            $status = 'Excellent';
                            $statusClass = 'success';
                        } elseif ($student->cgpa >= 2.5) {
                            $status = 'Good';
                            $statusClass = 'good';
                        } else {
                            $status = 'Probation';
                            $statusClass = 'warning';
                        }
                    @endphp
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->session->year }}</td>
                        <td>{{ $student->program->faculty }} - {{ $student->program->department }}</td>
                        <td>{{ $student->cgpa }}</td>
                        <td><span class="status {{ $statusClass }}">{{ $status }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="no-results">
        <i class="fas fa-info-circle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
        <h3>No Students Found</h3>
        <p>Try adjusting your filter criteria to see more results.</p>
    </div>
@endif