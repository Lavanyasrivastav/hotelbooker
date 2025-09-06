<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Crop Image</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

    body { background: #020c15ff; font-family: 'Inter', sans-serif; color:white; }
    .container { max-width: 600px; margin-top: 50px; }
    .preview-img { width: 100%; max-height: 250px; object-fit: cover; border-radius: 10px; margin-top: 10px; }

    .nav{ display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; }
    .brand{ display:flex; align-items:center; gap:12px; }
    .brand-logo{ width: 40px; height: 40px; border-radius: 14px; background: conic-gradient(from 220deg, #22c55e, #16a34a);
      box-shadow: inset 0 0 18px rgba(255,255,255,.25), 0 8px 25px rgba(34,197,94,.25);
      position: relative; isolation: isolate;
    }
    .brand-logo::after{ content:""; position:absolute; inset:3px; border-radius: 12px; background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.3), transparent 50%); }
    .brand h1{ font-size: 1.1rem; line-height: 1.1; margin:0; font-weight: 700; }
    .brand small{ display:flex; color: var(--muted); font-weight: 500; }

    .controls{ display:flex; gap:10px; align-items:center; }
    .btn, button, input[type="submit"]{
      --pad: 12px 16px;
      padding: var(--pad); border: 0; border-radius: 999px; background: #1f2937; color: var(--text);
      display:flex; align-items:center; gap:8px; font-weight: 600; cursor: pointer;
      box-shadow: 0 2px 0 rgba(255,255,255,0.06) inset, 0 10px 20px rgba(0,0,0,.25);
      transition: transform .15s ease, box-shadow .2s ease, background .2s ease;

      .btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow); }
    .btn:focus-visible{ outline: none; box-shadow: var(--focus); }
    .btn-primary{ background: linear-gradient(180deg, var(--accent), var(--accent-2)); }
    .btn-ghost{ background: transparent; border: 1px solid rgba(148,163,184,.2); }

    .layout{ display:block; grid-template-columns: 1.2fr 1fr; gap: 18px; margin-top: 38px;margin-bottom: 38px; }
    @media (max-width: 960px){ .layout{ grid-template-columns: 1fr; } }

    .card{
      background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
      border: 1px solid rgba(148,163,184,.15); border-radius: var(--radius-2xl);
      box-shadow: var(--shadow);
      overflow: clip;
      margin-top: 38px  ;
    }
    .card-header{ display:flex; align-items:center; justify-content:space-between; gap:10px; padding: 16px 16px 10px; }
    .card-title{ font-weight: 700; margin: 0; font-size: 1.1rem; letter-spacing:.2px; }
    .card-sub{ color: var(--muted); font-size:.9rem; }
    .card-body{ padding: 16px; }

    .grid{ display:grid; gap: 12px; }
    .grid-2{ grid-template-columns: repeat(2, 1fr); }
    .grid-3{ grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 720px){ .grid-2, .grid-3{ grid-template-columns: 1fr; } }

    label{ display:block; font-weight: 600; margin-bottom: 6px; }
    .hint{ color: var(--muted); font-size: .9rem; }

    .field{
      background: #0b1222; border:1px solid rgba(148,163,184,.18); color: var(--text);
      border-radius: var(--radius-lg); padding: 12px 12px; width: 100%;
      transition: box-shadow .2s ease, border-color .2s ease;
    }
    .field:focus{ outline: none; border-color: var(--accent); box-shadow: var(--focus); }
    select.field{ appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill="%23cbd5e1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.25 7.5L10 12.25 14.75 7.5"/></svg>'); background-repeat:no-repeat; background-position: right 10px center; background-size: 18px; padding-right: 36px; }

    .switch{ display:flex; align-items:center; gap: 10px; }
    .switch input{ appearance: none; width: 48px; height: 28px; background:#1f2937; border-radius: 999px; position:relative; outline:none; border:1px solid rgba(148,163,184,.25); cursor:pointer; transition: background .2s; }
    .switch input::after{ content:""; position:absolute; top:2px; left:2px; width:24px; height:24px; border-radius: 50%; background: white; transition: transform .25s ease; }
    .switch input:checked{ background: var(--accent-2); border-color: transparent; }
    .switch input:checked::after{ transform: translateX(20px); }

    }
</style>
</head>
<body>
    <header>
    <nav class="nav app" aria-label="Main">
      <div class="brand">
        <div class="brand-logo" aria-hidden="true"></div>
        <div>
          <h1>Smart Krishi Sahayak</h1>
          <small class="dev" id="subtitle">Farmer‑friendly crop advice</small>
        </div>
      </div>
      <div class="controls">
        <div class="reader-controls">
          <button class="btn btn-ghost" id="toggle-simple" aria-pressed="false" title="Switch to Simple Mode">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span id="simple-label">Simple</span>
          </button>
          <div class="tip">
            <button class="btn btn-ghost" id="decrease-font" aria-label="Decrease text size">A−</button>
            <div class="tip-box">Text size</div>
          </div>
          <div class="tip">
            <button class="btn btn-ghost" id="increase-font" aria-label="Increase text size">A+</button>
            <div class="tip-box">Text size</div>
          </div>
        </div>
        <label class="tip">
          <select id="lang" class="field" aria-label="Select language">
            <option value="en">English</option>
            <option value="hi">हिंदी</option>
            <option value="mr">मराठी</option>
          </select>
          <span class="tip-box">Language</span>
        </label>
        <button class="btn btn-primary" id="speak" aria-label="Read advice aloud">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 5l6 4v6l-6 4V5z"/><path d="M7 6h1v12H7z"/></svg>
          <span id="speak-label">Listen</span>
        </button>
        <li ><a href="signup.php">Sign Up</a></li>
        <li><a href="upload_crop.php" class="btn btn-success btn-sm mt-3">Upload Crop Image</a></li>


      </div>
    </nav>
  </header>

<div class="container">
    <h2 class="text-center text-success mb-4">Upload Crop Image for Advisory</h2>
    
    <form id="uploadForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Choose Crop Image</label>
            <input type="file" class="form-control" name="crop_image" id="crop_image" accept="image/*" required>
        </div>
        <img id="preview" class="preview-img d-none" />
        <button type="submit" class="btn btn-success w-100 mt-3">Get Advice</button>
    </form>

    <div id="result" class="mt-4"></div>
</div>

<script>
document.getElementById('crop_image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('uploadForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    document.getElementById('result').innerHTML = `<div class="alert alert-info">Analyzing your image, please wait...</div>`;

    try {
        const res = await fetch('process_crop_image.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.status === "success") {
            document.getElementById('result').innerHTML = `
                <div class="card p-3">
                    <h4 class="text-success">Advice for Your Crop</h4>
                    <p><strong>Diagnosis:</strong> ${data.diagnosis}</p>
                    <p><strong>Recommendation:</strong> ${data.recommendation}</p>
                    <p><strong>Organic Alternative:</strong> ${data.organic}</p>
                </div>
            `;
        } else {
            document.getElementById('result').innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    } catch (err) {
        document.getElementById('result').innerHTML = `<div class="alert alert-danger">Server error, please try again.</div>`;
    }
});
</script>

</body>
</html>
