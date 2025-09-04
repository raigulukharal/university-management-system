<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records System - University Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #1a365d;
            --secondary: #d4af37;
            --accent: #2b6cb0;
            --light: #f8f9fa;
            --dark: #2d3748;
            --success: #38a169;
            --danger: #e53e3e;
            --gray: #718096;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7f9;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .university-header {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .university-brand {
            display: flex;
            align-items: center;
        }
        
        .university-logo {
            font-size: 2.5rem;
            margin-right: 1rem;
            color: var(--secondary);
        }
        
        .university-name {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .university-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .card-header {
            background: var(--primary);
            color: white;
            padding: 1.2rem 1.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        
        .card-header i {
            margin-right: 10px;
            color: var(--secondary);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .filter-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.2rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.2);
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background: #2a4365;
            transform: translateY(-2px);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .results-section {
            margin-top: 2rem;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .students-table th {
            background: var(--primary);
            color: white;
            text-align: left;
            padding: 1rem;
            font-weight: 600;
        }
        
        .students-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .students-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .students-table tr:hover {
            background-color: #edf2f7;
        }
        
        .no-results {
            text-align: center;
            padding: 2rem;
            color: var(--gray);
            font-style: italic;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }
        
        .loading i {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }
        
        .stats-bar {
            display: flex;
            justify-content: space-between;
            background: #edf2f7;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
        }
        
        .stat-item i {
            margin-right: 0.5rem;
            color: var(--accent);
        }
        
        .status.success {
            color: var(--success);
            font-weight: 600;
        }
        
        .status.good {
            color: var(--accent);
            font-weight: 600;
        }
        
        .status.warning {
            color: var(--danger);
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .filter-section {
                grid-template-columns: 1fr;
            }
            
            .university-header {
                flex-direction: column;
                text-align: center;
                padding: 1rem;
            }
            
            .university-brand {
                margin-bottom: 1rem;
            }
        }
        
        .footer {
            background: var(--primary);
            color: white;
            text-align: center;
            padding: 1.5rem;
            margin-top: 3rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header class="university-header">
        <div class="university-brand">
            <i class="fas fa-graduation-cap university-logo"></i>
            <div>
                <div class="university-name">Baba Guru Nanak University</div>
                <div class="university-subtitle">Center for Academic Excellence Since 2022</div>
            </div>
        </div>
        <div class="user-actions">
            <button class="btn"><i class="fas fa-user"></i> ITRC Pannel</button>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-filter"></i> Student Records
            </div>
            <div class="card-body">
                <div class="stats-bar">
                    <div class="stat-item">
                        <i class="fas fa-database"></i> Total Students: 2,000
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clock"></i> Last updated: {{ \Carbon\Carbon::now()->format('l, h:i A') }}
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="form-group">
                        <label for="session"><i class="fas fa-calendar-alt"></i> Academic Session</label>
                        <select id="session" class="form-control">
                            <option value="">Select Session</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session->id }}">{{ $session->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="program"><i class="fas fa-graduation-cap"></i> Program of Study</label>
                        <select id="program" class="form-control">
                            <option value="">Select Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->faculty }} - {{ $program->department }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card results-section">
            <div class="card-header">
                <i class="fas fa-users"></i> Student Results
            </div>
            <div class="card-body">
                <div class="loading">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Loading student records...</p>
                </div>
                
                <div id="studentsData">
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>© 2025 BGNU. All rights reserved.</p>
        <p>Student Records System v3.2 | <a href="#" style="color: var(--secondary);">Privacy Policy</a> | <a href="#" style="color: var(--secondary);">Terms of Use</a></p>
    </footer>

    <script>
        $(document).ready(function(){
          
            $('.loading').hide();
            
            function loadStudents() {
                var session_id = $('#session').val();
                var program_id = $('#program').val();
                if (session_id === '' && program_id === '') {
                    $('#studentsData').html('');
                    return;
                }
                $('.loading').show();
                $('#studentsData').html('');

                $.ajax({
                    url: "{{ route('students.filter') }}",
                    type: 'GET',
                    data: { session_id: session_id, program_id: program_id },
                    success: function(response){
                        $('.loading').hide();
                        $('#studentsData').html(response);
                    },
                    error: function() {
                        $('.loading').hide();
                        alert('An error occurred while fetching data. Please try again.');
                    }
                });
            }
            $('#session, #program').change(loadStudents);
        });
    </script>
</body>
</html>