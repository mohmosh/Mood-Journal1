<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Mood Journals — Silent Echoes</title>

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

    <!-- Journals section -->
    <div class="container my-5">
        <!-- Motivational header -->
        <div class="mb-4">
            <h1 class="text-white mb-2">Your Mood Journal - {{ $moodJournal->mood }}</h1>
            <p class="text-light fst-italic">"Writing is the painting of the voice." – Voltaire</p>
        </div>

        <!-- Flash message -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Mood Journal Details -->
        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width,initial-scale=1" />
            <title>Mood Journals — Silent Echoes</title>

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

            <!-- Journals section -->
            <div class="container my-5">
                <!-- Motivational header -->
                <div class="mb-4">
                    <h1 class="text-white mb-2">Your Mood Journal - {{ $moodJournal->mood }}</h1>
                    <p class="text-light fst-italic">"Writing is the painting of the voice." – Voltaire</p>
                </div>

                <!-- Flash message -->
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif




                <div class="notebook-card mx-auto" style="cursor: default; width: 500px;">
                    <h3 class="notebook-title">{{ $moodJournal->mood }}</h3>
                    <small class="text-muted">{{ $moodJournal->entry_date->format('M d, Y') }}</small>

                    <div class="entry-preview mt-3">
                        {!! $moodJournal->entry !!}
                    </div>

                    <!-- AI Response Section -->
                    @if($moodJournal->response)
                    <div class="encouragement-card mt-4">
                        <h5 class="mb-2">💡 Encouragement</h5>
                        <p class="mb-3">{{ $moodJournal->response->encouragement }}</p>

                        <h6 class="text-success">📖 Bible Verse</h6>
                        <blockquote class="bible-verse">
                            <span class="quote-mark">“</span>{{ $moodJournal->response->bible_verse }}<span class="quote-mark">”</span>
                        </blockquote>
                    </div>
                    @else
                    <div class="mt-4 text-muted fst-italic">
                        No encouragement generated yet for this entry.
                    </div>
                    @endif

                    <!-- Action buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('mood-journals.edit', $moodJournal) }}" class="btn btn-primary">Edit</a>

                        <form action="{{ route('mood-journals.destroy', $moodJournal) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this journal entry?')">Delete</button>
                        </form>
                    </div>

                    <!-- Back button -->
                    <div class="mt-4">
                        <a href="{{ route('mood-journals.index') }}" class="btn btn-mood">Back to Journals</a>
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

                    .notebook-card {
                        background: #fff8f0;
                        border-radius: 20px;
                        width: 500px;
                        /* Adjusted for the single journal view */
                        height: auto;
                        padding: 1.5rem;
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                        border-left: 8px solid #f0c27b;
                        color: black;
                        transition: transform 0.2s ease, box-shadow 0.2s ease;
                    }

                    .notebook-card:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 12px 45px rgba(0, 0, 0, 0.4);
                    }

                    .notebook-title {
                        font-family: "Brush Script MT", cursive;
                        font-size: 1.6rem;
                        margin-bottom: 0.5rem;
                    }

                    .entry-preview {
                        margin-top: 0.5rem;
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

                    .encouragement-card {
                        background: #f9f9ff;
                        border-radius: 15px;
                        border-left: 6px solid #7c8bff;
                        padding: 1rem 1.2rem;
                        box-shadow: 0 4px 15px rgba(124, 139, 255, 0.2);
                        transition: transform 0.2s ease, box-shadow 0.2s ease;
                    }

                    .encouragement-card:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 6px 20px rgba(124, 139, 255, 0.35);
                    }

                    /* Bible Verse Styling */
                    .bible-verse {
                        background: #eaf7ed;
                        border-left: 4px solid #28a745;
                        border-radius: 8px;
                        font-style: italic;
                        font-size: 0.95rem;
                        padding: 0.8rem 1rem;
                        margin: 0;
                        color: #155724;
                        position: relative;
                    }

                    .bible-verse .quote-mark {
                        font-size: 1.3rem;
                        font-weight: bold;
                        color: #28a745;
                    }
                </style>
        </body>

        </html>








        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

            .notebook-card {
                background: #fff8f0;
                border-radius: 20px;
                width: 500px;
                /* Adjusted for the single journal view */
                height: auto;
                padding: 1.5rem;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                border-left: 8px solid #f0c27b;
                color: black;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .notebook-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 45px rgba(0, 0, 0, 0.4);
            }

            .notebook-title {
                font-family: "Brush Script MT", cursive;
                font-size: 1.6rem;
                margin-bottom: 0.5rem;
            }

            .entry-preview {
                margin-top: 0.5rem;
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
        </style>
</body>

</html>