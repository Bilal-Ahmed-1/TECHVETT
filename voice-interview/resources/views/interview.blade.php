<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI HR Interview</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      margin: 0;
      padding: 0;
      background: #0e0e0e;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      overflow: hidden;
      color: #fff;
    }

    #particles-js, #floating-blobs { position: fixed; width: 100%; height: 100%; z-index: -2; }
    #floating-blobs { z-index: -1; }

    .particle {
      position: fixed;
      top: -10px;
      width: 8px;
      height: 8px;
      background: radial-gradient(circle, #00e5ff, transparent);
      border-radius: 50%;
      opacity: 0.6;
      animation: floatDown linear infinite;
      z-index: -3;
      pointer-events: none;
    }

    @keyframes floatDown { to { transform: translateY(110vh); opacity: 0; } }

    .blob {
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(0,229,255,0.6), rgba(0,153,204,0.1));
      border-radius: 50%;
      animation: float 12s ease-in-out infinite;
      filter: blur(100px);
    }

    .blob:nth-child(1) { top: 15%; left: 10%; animation-delay: 0s; }
    .blob:nth-child(2) { top: 60%; left: 70%; animation-delay: 3s; }
    .blob:nth-child(3) { top: 40%; left: 40%; animation-delay: 6s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-60px) scale(1.2); }
    }

    .heading {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 15px;
      color: #00e5ff;
    }

    /* Main Card Container */
    #container {
      max-width: 550px;
      margin: auto;
      padding: 30px;
      margin-top: 7vh;
      border-radius: 16px;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      text-align: center;
      z-index: 2;
      animation: fadeIn 1.5s ease;
      position: relative;
      box-shadow: none;
    }

    #status {
      font-size: 1.6rem;
      margin-bottom: 30px;
      animation: fadeText 2s ease-in-out infinite;
    }

    @keyframes fadeText { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

    .mic-wrapper {
      position: relative;
      width: 160px;
      height: 160px;
      margin: 50px auto;
      animation: micOrbit 8s linear infinite;
    }

    @keyframes micOrbit { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    #start {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      font-size: 2.2rem;
      border: none;
      color: white;
      background: #0e0e0e;
      position: absolute;
      top: 15px;
      left: 15px;
      z-index: 10;
    }

    /* Mic ring glow */
    .mic-ring {
      position: absolute;
      top: 0;
      left: 0;
      width: 160px;
      height: 160px;
      border-radius: 50%;
      animation: micGlow 4s ease-in-out infinite;
    }

    @keyframes micGlow {
      0%   { box-shadow: 0 0 6px #00e5ff, 0 0 12px #00e5ff, 0 0 30px #00e5ff; }
      50%  { box-shadow: 0 0 8px #ff4081, 0 0 20px #ff4081, 0 0 40px #ff4081; }
      100% { box-shadow: 0 0 6px #00e5ff, 0 0 12px #00e5ff, 0 0 30px #00e5ff; }
    }

    /* Waveform */
    #waveform {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 60px;
      margin-top: 40px;
      gap: 4px;
      visibility: hidden;
    }

    .wave {
      width: 4px;
      border-radius: 5px;
      animation: waveAnim 1.2s ease-in-out infinite, waveGlow 4s ease-in-out infinite;
      background: linear-gradient(to top, #00e5ff, #00bcd4);
    }

    @keyframes waveAnim {
      0%, 100% { height: 20px; }
      50% { height: 60px; }
    }

    @keyframes waveGlow {
      0%   { background: linear-gradient(to top, #00e5ff, #00bcd4); }
      50%  { background: linear-gradient(to top, #ff4081, #ff6f91); }
      100% { background: linear-gradient(to top, #00e5ff, #00bcd4); }
    }

    .wave:nth-child(1) { animation-delay: 0s, 0s; }
    .wave:nth-child(2) { animation-delay: 0.1s, 0s; }
    .wave:nth-child(3) { animation-delay: 0.2s, 0s; }
    .wave:nth-child(4) { animation-delay: 0.3s, 0s; }
    .wave:nth-child(5) { animation-delay: 0.4s, 0s; }
    .wave:nth-child(6) { animation-delay: 0.5s, 0s; }
    .wave:nth-child(7) { animation-delay: 0.6s, 0s; }

    .shimmer {
      padding: 15px;
      margin-top: 40px;
      font-weight: bold;
      text-align: center;
      border-radius: 16px;
      background: linear-gradient(135deg, #1f1f1f, #00e5ff, #1f1f1f, #ff4081, #1f1f1f);
      background-size: 600% 600%;
      animation: shimmerAnimation 8s ease infinite;
    }

    @keyframes shimmerAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ✅ Done button (hidden by default) */
    #doneBtn {
      display: none;
    }
  </style>
</head>

<body>
  <div id="particles-js"></div>
  <div id="floating-blobs">
    <div class="blob"></div><div class="blob"></div><div class="blob"></div>
  </div>

  <div class="container" id="container">
    <div class="heading">Stage 3: Voice over Voice Analysis</div> <!-- 🔹 Now inside the container -->

    <div id="status">Press the button to start</div>

    <div class="mic-wrapper">
      <div class="mic-ring" id="micRing"></div>
      <button id="start">🎤</button>
    </div>

    <div id="waveform">
      <div class="wave"></div><div class="wave"></div><div class="wave"></div>
      <div class="wave"></div><div class="wave"></div><div class="wave"></div><div class="wave"></div>
    </div>

    <div class="shimmer mt-4">AI Interviewing Now...</div>

    <!-- ✅ Hidden Done Button -->
    <div class="d-flex justify-content-end mt-4">
      <button id="doneBtn" class="btn btn-success px-4 py-2 fw-bold">
        ✅ Done
      </button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@ffmpeg/ffmpeg@0.11.5/dist/ffmpeg.min.js"></script>
  <script src="{{ asset('js/voice.js') }}"></script>
</body>
</html>
