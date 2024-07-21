<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan Siswa - Hideaki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" />
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .hero-section {
            background: url('{{ asset('assets/images/bg.jpg') }}') no-repeat center center;
            background-size: cover;
            height: 100vh;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .features-section {
            padding: 4rem 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 2rem 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="path/to/your/logo.png" alt="Ga Tau Mau Pake Logo Apa" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4">Welcome to ??</h1>
            <p class="lead">Effortlessly manage student finances with ??.</p>
            <a href="#features" class="btn btn-primary btn-lg">Learn More</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Easy Management</h5>
                            <p class="card-text">Manage student finances with ease and efficiency using our intuitive platform.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Detailed Reports</h5>
                            <p class="card-text">Generate detailed financial reports to keep track of student expenses and income.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Secure & Reliable</h5>
                            <p class="card-text">Ensure the security and reliability of your financial data with our robust system.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Haudy. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
