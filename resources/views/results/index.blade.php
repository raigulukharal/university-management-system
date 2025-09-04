<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4895ef;
            --accent: #4cc9f0;
            --success: #2ec4b6;
            --warning: #ff9f1c;
            --danger: #e71d36;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --card-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }

        body {
            background-color: #f5f7ff;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #343a40;
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 1.2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .app-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 25px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .reset-btn-container {
            margin-bottom: 0;
        }

        .btn-reset {
            background: linear-gradient(135deg, var(--danger) 0%, #c81d4e 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(231, 29, 54, 0.3);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 29, 54, 0.4);
        }

        .btn-reset:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-box input {
            border-radius: 50px;
            padding: 14px 25px;
            border: 2px solid #e9ecef;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            font-size: 0.90rem;
            width: 100%;
        }

        .search-box input:focus {
            border-color: var(--primary-light);
            box-shadow: 0 3px 15px rgba(67, 97, 238, 0.15);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .session-selector {
            padding: 0;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .session-selector label {
            font-weight: 600;
            margin-right: 5px;
            color: var(--primary-dark);
        }

        .session-selector select {
            padding: 10px 20px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: var(--transition);
            background: white;
            cursor: pointer;
        }

        .session-selector select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-box {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            border-top: 4px solid var(--primary);
        }

        .stat-box:nth-child(2) { border-top-color: var(--danger); }
        .stat-box:nth-child(3) { border-top-color: var(--warning); }
        .stat-box:nth-child(4) { border-top-color: var(--success); }
        .stat-box:nth-child(5) { border-top-color: var(--accent); }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--primary-dark);
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }

        .footer {
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            color: white;
        }

        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 30px auto;
        }

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        #data-container {
            margin-top: 20px;
            padding: 25px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .card-title {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f2f5;
        }
        @media (max-width: 768px) {
            .navbar-brand { font-size: 0.9rem; }
            .footer p { font-size: 0.85rem; }
            .dashboard-header { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
            .search-box { max-width: 100%; }
            .search-icon { display: none; }
            .session-selector { justify-content: flex-start; width: 100%; gap: 10px; }
            .search-box input {font-size: 0.90rem;}
        }

        @media (min-width: 769px) {
            .dashboard-header { flex-direction: row; align-items: center; gap: 15px; }
            .session-selector { flex-direction: row; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-journal-bookmark-fill me-2"></i>
                Student Results Management System
            </a>
        </div>
    </nav>

    <div class="app-container">
        <div class="dashboard-header">
            <div class="reset-btn-container">
                <button id="resetDataBtn" class="btn-reset">
                    <i class="bi bi-arrow-clockwise me-2"></i>Reset Data
                </button>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by student name & roll number.">
                <i class="bi bi-search search-icon"></i>
            </div>
            <div class="session-selector">
                <label for="sessionSelect">Select Session:</label>
                <select name="session" id="sessionSelect">
                    @foreach($sessions as $sess)
                        <option value="{{ $sess }}" {{ $selectedSession == $sess ? 'selected' : '' }}>{{ $sess }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-number">{{ $stats['total_students'] }}</div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['fail_count'] }}</div>
                <div class="stat-label">Dropped Students</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['less_than_3'] }}</div>
                <div class="stat-label">Students < 3.0 GPA</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ $stats['greater_than_3'] }}</div>
                <div class="stat-label">Students >= 3.0 GPA</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">{{ number_format($stats['session_gpa'], 2) }}</div>
                <div class="stat-label">Session GPA</div>
            </div>
        </div>

        <div id="data-container">
            <div class="text-center">
                <div class="loader"></div>
                <p>Loading data...</p>
            </div>
        </div>
    </div>

    <div class="footer mt-5">
        <p class="mb-1 text-white">Student Results Management System &copy; 2025</p>
        <p class="mb-0 text-white">Developed with ❤️ using Laravel</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            loadData();
            checkMasterData();

            $('#searchInput').on('keyup', function() {
                const searchText = $(this).val();
                const session = $('#sessionSelect').val();
                loadData(searchText, session);
            });

            $('#sessionSelect').change(function() {
                const session = $(this).val();
                loadData($('#searchInput').val(), session);
            });

            $('#resetDataBtn').click(function() {
                if (confirm('Are you sure you want to reset all data from masters table? This will clear current results.')) {
                    resetData();
                }
            });

            function loadData(search = '', session = '{{ $selectedSession }}') {
                $('#data-container').html('<div class="text-center"><div class="loader"></div><p>Loading data...</p></div>');

                $.get('{{ route("results.data") }}', {search: search, session: session}, function(data) {
                    $('#data-container').html(data);
                }).fail(function() {
                    $('#data-container').html('<div class="alert alert-danger">Error loading data. Please try again.</div>');
                });
            }

            function checkMasterData() {
                $.get('{{ route("results.check.master.data") }}', function(response) {
                    if (!response.has_data) {
                        $('#resetDataBtn').prop('disabled', true)
                            .html('<i class="bi bi-exclamation-triangle me-2"></i>No Master Data Available');
                    }
                });
            }

            function resetData() {
                $('#resetDataBtn').prop('disabled', true).html('<i class="bi bi-arrow-clockwise me-2"></i>Resetting...');

                $.post('{{ route("results.reset.data") }}', {
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    if (response.success) {
                        alert('Data reset successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                        $('#resetDataBtn').prop('disabled', false).html('<i class="bi bi-arrow-clockwise me-2"></i>Reset Data');
                    }
                }).fail(function(xhr) {
                    alert('Error resetting data. Please try again.');
                    $('#resetDataBtn').prop('disabled', false).html('<i class="bi bi-arrow-clockwise me-2"></i>Reset Data');
                    console.error('Reset error:', xhr.responseText);
                });
            }
        });
    </script>
</body>
</html>
