<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Mood Journals — Silent Echoes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
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
                <a href="{{ route('logout') }}" class="btn btn-danger ms-2"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>





    <div class="container my-5">
        <!-- Motivational header -->
        <div class="mb-4">
            <h1 class="text-white mb-2">Let's get writing 😄</h1>
            <p class="text-light fst-italic">"Writing is the painting of the voice." – Voltaire</p>
        </div>

        <div class="mb-4">
            <!-- <button class="btn btn-success" id="donate-btn">Donate</button> -->

            <!-- Donate Button -->
            <div class="mb-4">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#donateModal">
                    Donate
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="donateModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="donateForm" method="POST" action="{{ route('donate.stk') }}">
                        @csrf
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">Donate via M-Pesa</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal Body -->
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Amount (Ksh)</label>
                                    <input type="number" name="amount" class="form-control" required min="1" placeholder="Enter amount">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" required placeholder="2547XXXXXXXX">
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success w-100">Donate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Flash message -->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <!-- Journals Section (Left) -->
                <div class="col-md-6"> <!-- Changed col-lg-6 to col-md-6 -->
                    @if($journals->count())
                    <div class="journals-grid d-flex flex-wrap gap-3">

                        @foreach($journals as $journal)
                        <div class="notebook-card" style="cursor:pointer;" onclick="window.location='{{ route('mood-journals.show', $journal) }}'">
                            <h3 class="notebook-title">{{ $journal->mood }}</h3>
                            <small class="text-muted">{{ $journal->entry_date->format('M d, Y') }}</small>
                            <div class="entry-preview">{!! Str::limit($journal->entry, 150) !!}</div>
                        </div>


                        @endforeach

                    </div>

                    @else
                    <p class="text-white fs-5">No mood journals yet. Create your first one!</p>
                    @endif
                </div>

                <!-- Mood Trend Chart Section (Right) -->
                <div class="col-md-6"> <!-- Changed col-lg-6 to col-md-6 -->
                    <div class="card bg-white p-3">
                        <h3 class="text-dark">Mood Trend</h3>
                        <canvas id="moodChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- New Entry button at bottom -->
            <div class="mt-4">
                <a href="{{ route('mood-journals.create') }}" class="btn btn-mood">➕ New Entry</a>
            </div>
        </div>







        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


        <script>
            const moodData = @json($moods);

            // Extract dates and emotion scores
            const labels = moodData.map(item => item.entry_date);
            const data = moodData.map(item => {
                // Make sure scores don’t exceed 100
                return Math.min(100, Math.max(0, item.emotion_score));
            });

            const ctx = document.getElementById('moodChart').getContext('2d');
            const moodChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Mood Trend',
                        data: data,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.2,
                        pointBackgroundColor: 'rgb(75, 192, 192)',
                        pointRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100, // ✅ keep graph within 0–100
                            ticks: {
                                stepSize: 10, // ✅ 0, 10, 20 ... 100
                                callback: function(value) {
                                    return value + '%'; // show percentage
                                }
                            }
                        }
                    }
                }
            });
        </script>

        <script>
            document.getElementById('donate-btn').addEventListener('click', function() {
                let amount = prompt("Thank you for choosing to support me, Enter the amount you want to donate ($):");

                if (amount && !isNaN(amount) && amount > 0) {
                    window.location.href = `/donate?amount=${amount}`;
                } else {
                    alert("Please enter a valid amount.");
                }
            });
        </script>






        <style>
            body {
                margin: 0;
                min-height: 100vh;
                font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
                color: #e6eefc;
                position: relative;
                overflow-x: hidden;
                background: #0d0d0d;
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

            .logo {
                font-weight: 800;
                font-size: 2rem;
                background: linear-gradient(90deg, #7cffea, #7c8bff, #ff9fbf);
                -webkit-background-clip: text;
                color: transparent;
            }

            .journals-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1.5rem;
                justify-items: center;
                justify-content: flex-start;
            }

            .notebook-card {
                background: #fff8f0;
                border-radius: 20px;
                width: 250px;
                height: 350px;
                padding: 1.5rem;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                border-left: 8px solid #f0c27b;
                cursor: pointer;
                color: black;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                display: flex;
                flex-direction: column;
                margin-bottom: 1rem;
            }

            .notebook-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 45px rgba(0, 0, 0, 0.4);
            }

            .notebook-card::before {
                content: '';
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                width: 6px;
                background: repeating-linear-gradient(to bottom, #d4a373 0px, #d4a373 4px, #f0c27b 4px, #f0c27b 8px);
                border-radius: 4px 0 0 4px;
            }

            .notebook-title {
                font-family: "Brush Script MT", cursive;
                font-size: 1.6rem;
                margin-bottom: 0.5rem;
            }

            .entry-preview {
                margin-top: 0.5rem;
                overflow: hidden;
                flex-grow: 1;
            }

            .btn-mood {
                display: inline-block;
                padding: 0.6rem 1.4rem;
                font-weight: 600;
                font-size: 1rem;
                color: #fff;
                background: linear-gradient(90deg, #7cffea, #7c8bff, #ff9fbf);
                border: none;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(124, 139, 255, 0.4);
                text-decoration: none;
                transition: all 0.3s ease-in-out;
            }

            .btn-mood:hover {
                transform: translateY(-2px) scale(1.02);
                box-shadow: 0 6px 20px rgba(124, 139, 255, 0.6);
                opacity: 0.95;
            }

            .modal .form-control {
                color: black !important;
                /* Text color inside input */
                background-color: #fff !important;
                /* Ensure white background */
                border-color: #ced4da !important;
                /* Normal border */
            }

            .modal .form-control::placeholder {
                color: #555 !important;
                /* Darker placeholder text */
                opacity: 1 !important;
            }

            .modal .modal-header {
                border-bottom: none;
                /* Optional cleaner look */
            }

            .modal .modal-footer {
                border-top: none;
                /* Optional cleaner look */
            }
        </style>
</body>

</html>