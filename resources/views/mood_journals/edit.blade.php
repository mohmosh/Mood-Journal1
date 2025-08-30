<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Edit Mood Journal Entry — Silent Echoes</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.min.css">
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
        <a href="{{ route('mood-journals.index') }}" class="btn btn-outline-light">Back to Journals</a>
      </div>
    </div>
  </nav>

  <!-- Centered notebook card -->
  <div class="d-flex justify-content-center align-items-start py-5">
    <div class="notebook-card">
      <h2 class="text-center mb-4 notebook-title">Edit Mood Journal Entry</h2>

      <form action="{{ route('mood-journals.update', $moodJournal) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Mood input with emoji picker -->
        <div class="mb-3">
          <label class="form-label">Mood</label>
          <div class="d-flex align-items-center">
            <input type="text" name="mood" id="mood" class="form-control me-2" 
                   value="{{ old('mood', $moodJournal->mood) }}" required>
            <button type="button" id="emoji-button" class="btn btn-outline-secondary">😀</button>
          </div>
          @error('mood') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Rich text editor for entry -->
        <div class="mb-3">
          <label class="form-label">Entry</label>
          <div id="editor" style="height:200px;">{!! old('entry', $moodJournal->entry) !!}</div>
          <input type="hidden" name="entry" id="entry">
          @error('entry') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- <div class="mb-3">
          <label class="form-label">Tags (comma separated)</label>
          <input type="text" name="tags[]" class="form-control" 
                 value="{{ old('tags', implode(',', $moodJournal->tags ?? [])) }}">
        </div> -->

        <div class="mb-3">
          <label class="form-label">Entry Date</label>
          <input type="datetime-local" name="entry_date" class="form-control" 
                 value="{{ old('entry_date', $moodJournal->entry_date->format('Y-m-d\TH:i')) }}" required>
          @error('entry_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex justify-content-between mt-4">
          <button type="submit" class="btn btn-mood">Update</button>
          <a href="{{ route('mood-journals.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.2/dist/index.min.js"></script>

  <script>
    // Quill editor
    var quill = new Quill('#editor', {
      theme: 'snow',
      placeholder: 'Write your mood here...',
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          ['blockquote', 'code-block'],
          [{ 'header': 1 }, { 'header': 2 }],
          [{ 'list': 'ordered' }, { 'list': 'bullet' }],
          ['clean']
        ]
      }
    });

    // Submit quill content
    var form = document.querySelector('form');
    form.onsubmit = function() {
      document.querySelector('#entry').value = quill.root.innerHTML;
    };

    // Emoji picker for mood
    const button = document.querySelector('#emoji-button');
    const input = document.querySelector('#mood');
    const picker = new EmojiButton({ position: 'bottom-start', showPreview: true, showSearch: true });

    picker.on('emoji', emoji => {
      input.value += emoji;
      input.focus();
    });

    button.addEventListener('click', () => picker.togglePicker(button));
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

    .nb1 { left: -40px; top: 40px; background: radial-gradient(circle,#ff4da6,#ffd86b); animation-duration: 18s; }
    .nb2 { right: -40px; bottom: 70px; background: radial-gradient(circle,#7cffea,#7c8bff); animation-duration: 12s; animation-direction: reverse; }
    .nb3 { left: 40%; top: -80px; width: 260px; height: 260px; background: radial-gradient(circle,#ff9fbf,#ffa96b); animation-duration: 20s; opacity:0.85; }

    @keyframes spin { from {transform:rotate(0deg);} to {transform:rotate(360deg);} }

    .notebook-card {
      background: #fff8f0;
      border-radius: 20px;
      width: 600px;
      max-width: 95%;
      padding: 3rem 2rem;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      border-left: 10px solid #f0c27b;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      position: relative;
      color: black;
    }

    .notebook-card::before {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      width: 6px;
      background: repeating-linear-gradient(to bottom,#d4a373 0px,#d4a373 4px,#f0c27b 4px,#f0c27b 8px);
      border-radius: 4px 0 0 4px;
    }

    .notebook-title {
      font-family: "Brush Script MT", cursive;
      font-size: 2.2rem;
      color: #333;
      margin-bottom: 1.5rem;
    }

    .notebook-card input, .notebook-card textarea { background:#fff; border:1px solid #ccc; color:#000; border-radius:6px; padding:0.5rem; }
    .notebook-card input:focus, .notebook-card textarea:focus { outline:none; border-color:#7c8bff; box-shadow:0 0 8px #7c8bff33; }

    .btn-mood { display:inline-block; padding:0.6rem 1.4rem; font-weight:600; font-size:1rem; color:#fff; background:linear-gradient(90deg,#7cffea,#7c8bff,#ff9fbf); border:none; border-radius:12px; box-shadow:0 4px 15px rgba(124,139,255,0.4); transition:all 0.3s ease-in-out; }
    .btn-mood:hover { transform:translateY(-2px) scale(1.02); box-shadow:0 6px 20px rgba(124,139,255,0.6); opacity:0.95; }

    .btn-secondary { background:#aaa; color:#fff; border:none; border-radius:12px; }
    .btn-secondary:hover { opacity:0.9; }

    .logo { font-weight:800; font-size:2rem; background:linear-gradient(90deg,#7cffea,#7c8bff,#ff9fbf); -webkit-background-clip:text; color:transparent; }
  </style>
</body>

</html>
