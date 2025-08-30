<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — Mood Journal</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- Background + neon blobs -->
  <div class="background-image"></div>
  <div class="neon-blob nb1" aria-hidden="true"></div>
  <div class="neon-blob nb2" aria-hidden="true"></div>
  <div class="neon-blob nb3" aria-hidden="true"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-transparent px-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold logo">Silent Echoes</a>
      <div>
        <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
      </div>
    </div>
  </nav>

  <!-- Centered login card -->
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card-glass" style="width: 550px; max-width: 95%;">
      <h2 class="text-center mb-4 logo">Mood Journal</h2>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember">
            <label class="form-check-label">Remember me</label>
          </div>
          <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      margin: 0;
      min-height: 100vh;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #e6eefc;
      position: relative;
      overflow-x: hidden;
    }

    .background-image {
      background: url("{{ asset('images/diary.jpg') }}") no-repeat center center / cover;
      position: fixed;
      inset: 0;
      z-index: -2;
      opacity: 0.9;
    }

    .neon-blob {
      position: absolute;
      width: 140px;
      height: 140px;
      border-radius: 50%;
      mix-blend-mode: screen;
      filter: blur(22px) saturate(1.2);
      animation: spin 14s linear infinite;
      z-index: -1;
      opacity: 0.92;
    }

    .nb1 {
      left: -40px;
      top: 40px;
      background: radial-gradient(circle, #ff4da6, #ffd86b);
      animation-duration: 18s;
    }

    .nb2 {
      right: -40px;
      bottom: 70px;
      background: radial-gradient(circle, #7cffea, #7c8bff);
      animation-duration: 12s;
      animation-direction: reverse;
    }

    .nb3 {
      left: 40%;
      top: -80px;
      width: 260px;
      height: 260px;
      background: radial-gradient(circle, #ff9fbf, #ffa96b);
      animation-duration: 20s;
      opacity: 0.85;
    }

    @keyframes spin {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }

    .card-glass {
      background: #fff; /* white background */
      border-radius: 22px;
      padding: 3rem;
      border: 1px solid rgba(0, 0, 0, 0.15);
      box-shadow: 0 12px 45px rgba(0, 0, 0, 0.2);
      color: #000; /* text black */
    }

    .card-glass input {
      background: #f9f9f9;
      border: 1px solid #ccc;
      color: #000;
    }

    .card-glass input:focus {
      outline: none;
      border-color: #7c8bff;
      box-shadow: 0 0 8px #7c8bff33;
    }

    .card-glass input::placeholder {
      color: #666;
    }

    .logo {
      font-weight: 800;
      font-size: 2rem;
      background: linear-gradient(90deg, #7cffea, #7c8bff, #ff9fbf);
      -webkit-background-clip: text;
      color: transparent;
    }

    .btn-primary {
      background: linear-gradient(90deg, #7cffea, #7c8bff, #ff9fbf);
      border: none;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }
  </style>
</body>

</html>
