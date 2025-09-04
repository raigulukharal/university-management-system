<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">🏫 University Management System</h1>
            <p class="lead text-muted">Complete Academic Management Solution</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-users fa-4x text-primary mb-3"></i>
                        <h3 class="card-title">Student Management</h3>
                        <p class="card-text">Manage student profiles, programs, and academic sessions</p>
                        <a href="{{ route('students.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-right"></i> Access
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-graduation-cap fa-4x text-success mb-3"></i>
                        <h3 class="card-title">Grade Management</h3>
                        <p class="card-text">Manage course grades, semesters, and student performance</p>
                        <a href="{{ route('grades.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-arrow-right"></i> Access
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body text-center p-4">
                        <i class="fas fa-chart-bar fa-4x text-info mb-3"></i>
                        <h3 class="card-title">Results Management</h3>
                        <p class="card-text">Real-time result editing and comprehensive analytics</p>
                        <a href="{{ route('results.index') }}" class="btn btn-info btn-lg text-white">
                            <i class="fas fa-arrow-right"></i> Access
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">System Statistics</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                            <h5>2,000+</h5>
                            <p>Students</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-book fa-2x text-success"></i>
                            <h5>50+</h5>
                            <p>Courses</p>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-calendar-alt fa-2x text-info"></i>
                            <h5>3</h5>
                            <p>Academic Sessions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>