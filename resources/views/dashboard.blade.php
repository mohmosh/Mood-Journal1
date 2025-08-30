<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard | {{ config('app.name', 'Mood Journal') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Mood Journal</a>
            <div>
                <span class="text-white me-3">
                    👋 Hi, {{ auth()->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container flex-grow-1 d-flex flex-column justify-content-center align-items-center py-5">
        <h1 class="display-5 fw-bold text-primary mb-3">Your Dashboard</h1>
        <p class="lead text-muted mb-4">Here’s an overview of your Mood Journal.</p>

        <div class="row g-4 w-100">
            <!-- Mood Journals -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Mood Journals</h5>
                        <p class="card-text text-muted">Track your daily moods and reflections.</p>
                        <a href="{{ route('mood-journals.index') }}" class="btn btn-primary">Go to Journals</a>
                    </div>
                </div>
            </div>

            <!-- Profile -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Profile</h5>
                        <p class="card-text text-muted">Update your personal information.</p>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit Profile</a>
                    </div>
                </div>
            </div>

            <!-- Settings (Optional Placeholder) -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Settings</h5>
                        <p class="card-text text-muted">Manage your account preferences.</p>
                        <a href="#" class="btn btn-outline-secondary">Coming Soon</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center py-3 shadow-sm mt-auto">
        <small class="text-muted">© {{ date('Y') }} Mood Journal. All rights reserved.</small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
