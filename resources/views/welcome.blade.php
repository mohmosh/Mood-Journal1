<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Mood Journal</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- Background image -->
  <div class="background-image"></div>

  <!-- Neon blobs (still overlayed on top of bg) -->
  <div class="neon-blob nb1" aria-hidden="true"></div>
  <div class="neon-blob nb2" aria-hidden="true"></div>
  <div class="neon-blob nb3" aria-hidden="true"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-transparent px-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold logo">Silent Echoes</a>
      <div class="d-flex gap-2 mt-4">
        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light">Register</a>
        <a href="{{ route('login') }}" class="btn btn-lg btn-primary">Login</a>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="card-glass">
          <div class="mb-3">
            <span class="logo">Mood Journal</span>
          </div>
          <h1 class="display-6">Write what you feel, see how you heal</h1>
          <div class="mt-4">
            <span class="pill me-2">Quick Check-ins</span>
            <span class="pill">Get Daily Motivation</span>
          </div>
        </div>
      </div>

      <div class="col-lg-6 text-center mt-4 mt-lg-0">
        <div class="card-glass" style="display:inline-block; width:340px;">
          <div style="height:28px; background:linear-gradient(90deg,#7cffea,#7c8bff,#ff9fbf); border-radius:10px; margin-bottom:12px;"></div>

          <div>
            <h5 class="text-heavy mb-3">Choose Your Mood</h5>
            <div class="d-flex justify-content-center gap-3">
              <div class="mood-avatar">😊</div>
              <div class="mood-avatar">😢</div>
              <div class="mood-avatar">😡</div>
              <div class="mood-avatar">😌</div>
              <div class="mood-avatar">😲</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quote section -->
    <div class="row mt-5 align-items-center justify-content-center text-center">
      <div class="col-md-3">
        <!-- <img src="{{ asset('images/boy.png') }}" alt="Happy boy avatar" class="happy-avatar img-fluid"> -->
      </div>

      <div class="col-md-6">
        <div class="quote-card">
          <div class="notebook">
            <blockquote class="quote-text">
              "Every mood is a step in your journey — embrace it, record it, and grow from it."
            </blockquote>
            <cite class="text-muted">— Mood Journal</cite>
          </div>
          <div class="pen"></div>
        </div>
      </div>


      <div class="col-md-3">
        <!-- <img src="{{ asset('images/girl.png') }}" alt="Happy Girl Avatar" class="happy-avatar img-fluid"> -->
      </div>
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

    /* 🔥 Background image */
    .background-image {
      background: url("{{ asset('images/diary.jpg') }}") no-repeat center center / cover;
      position: fixed;
      inset: 0;
      z-index: -2;
      opacity: 0.90;
      /*Fade it*/
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


    .quote-card cite {
      display: block;
      margin-top: 0.75rem;
      font-size: 2rem;
      /* bigger */
      font-style: italic;
      font-family: "Brush Script MT", cursive;
      /* handwriting look */
      color: #9fbfff;
    }


    .navbar .logo {
      font-size: 2rem;
      /* increase logo size */
      font-family: "Brush Script MT", cursive;
      /* handwriting effect */

    }





    @keyframes spin {
      from {
        transform: rotate(0deg) translateY(0);
      }

      to {
        transform: rotate(360deg) translateY(0);
      }
    }

    /* Glass effect */
    .card-glass {
      /* background: rgba(255, 255, 255, 0.05); */
      background: whitesmoke;
      border-radius: 18px;
      padding: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 12px 40px rgba(2, 6, 23, 0.6);
      backdrop-filter: blur(12px) saturate(120%);
      color: black;
    }

    .logo {
      font-weight: 800;
      letter-spacing: 1px;
      font-size: 1.05rem;
      background: linear-gradient(90deg, #7cffea, #7c8bff, #ff9fbf);
      -webkit-background-clip: text;
      color: transparent;
    }

    .pill {
      display: inline-block;
      padding: 6px 10px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.04);
      color: black;
      font-size: 0.85rem;
    }

    .mood-avatar {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: rgba(15, 23, 42, 0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      backdrop-filter: blur(6px);
      box-shadow: 0 0 10px rgba(124, 255, 234, 0.6);
      transition: transform .2s, box-shadow .2s;
    }

    .mood-avatar:hover {
      transform: scale(1.1);
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
    }

    /* .happy-avatar {
      max-height: 320px;
      filter: drop-shadow(0 0 15px rgba(124, 255, 234, 0.4));
    } */



    .quote-card {
      background: rgba(255, 255, 255, 0.05);
      /* background: whitesmoke; */
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(10px) saturate(120%);
      font-size: large;
    }















    .quote-text {
      font-size: 1.4rem;
      font-weight: 500;
      font-style: italic;
      color: black;
      line-height: 1.6;
      text-shadow:
        0 0 6px rgba(124, 255, 234, 0.8),
        0 0 12px rgba(124, 139, 255, 0.6),
        0 0 18px rgba(255, 159, 191, 0.5);
    }

    .quote-card cite {
      display: block;
      margin-top: 0.75rem;
      font-size: 0.9rem;
      color: #9fbfff;
    }
  </style>
</body>

</html>