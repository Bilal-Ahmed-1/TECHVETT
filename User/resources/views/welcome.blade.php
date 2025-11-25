<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TECHVETT</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Nabla:EDPT,EHLT@30..200,24&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #212626;
      font-family: 'Roboto Mono', monospace;
      color: #e0e0e0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
      text-align: center;
    }

    .text-container {
      display: flex;
      font-size: 5vw;
      /* font-family: 'Nabla', sans-serif; */
      flex-wrap: wrap;
      justify-content: center;
      gap: 5px;
      color: #90c3e4;
    }

    span {
      display: inline-block;
      opacity: 0;
      transform: translateY(20px) scale(0.95);
      animation: enterChar 0.5s ease-out forwards;
    }

    @keyframes enterChar {
      0% {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        text-shadow: none;
      }
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        text-shadow: 0 0 8px #90c3e4, 0 0 12px #90c3e4, 0 0 16px #90c3e4;
      }
    }

    @keyframes cyanPulseGlow {
      0% {
        text-shadow: 0 0 6px #90c3e4, 0 0 12px #90c3e4;
        color: #90c3e4;
      }
      50% {
        text-shadow: 0 0 12px #90c3e4, 0 0 24px #90c3e4;
        color: #90c3e4;
      }
      100% {
        text-shadow: 0 0 6px #90c3e4, 0 0 12px #90c3e4;
        color: #90c3e4;
      }
    }

    /* Delay each character */
    span:nth-child(1) { animation-delay: 0.1s; }
    span:nth-child(2) { animation-delay: 0.2s; }
    span:nth-child(3) { animation-delay: 0.3s; }
    span:nth-child(4) { animation-delay: 0.4s; }
    span:nth-child(5) { animation-delay: 0.5s; }
    span:nth-child(6) { animation-delay: 0.6s; }
    span:nth-child(7) { animation-delay: 0.7s; }
    span:nth-child(8) { animation-delay: 0.8s; }
    span:nth-child(9) { animation-delay: 0.9s; }
    span:nth-child(10) { animation-delay: 1.0s; }
    span:nth-child(11) { animation-delay: 1.1s; }
    span:nth-child(12) { animation-delay: 1.2s; }
    span:nth-child(13) { animation-delay: 1.3s; }
    span:nth-child(14) { animation-delay: 1.4s; }
    span:nth-child(15) { animation-delay: 1.5s; }
    span:nth-child(16) { animation-delay: 1.6s; }
    span:nth-child(17) { animation-delay: 1.7s; }

    .start-btn {
      margin-top: 40px;
      padding: 12px 28px;
      font-size: 16px;
      color: #09c3e4;
      background: none;
      border: none;
      position: relative;
      cursor: pointer;
      font-weight: bold;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeIn 0.8s ease-out forwards 2.2s;
    }

    .start-btn::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: -4px;
      width: 0%;
      height: 2px;
      background-color: #09c3e4;
      transition: width 0.3s ease;
    }

    .start-btn:hover::after {
      width: 100%;
    }

    .start-btn:hover {
      color: #ffffff;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="text-container" id="animatedText"></div>
  <button class="start-btn" onclick="window.location.href='/login'">Let's Get Started</button>

  <script>
    const text = "WELCOME TO TECHVETT";
    const container = document.getElementById("animatedText");

    text.split("").forEach((char, index) => {
      const span = document.createElement("span");
      span.textContent = char === " " ? "\u00A0" : char;
      container.appendChild(span);
    });

    // After all characters appear, pulse the entire text
    setTimeout(() => {
      container.innerHTML = `<h1 style="
        font-size: 5vw;
        color: #90c3e4;
        animation: cyanPulseGlow 2s infinite;
        text-shadow: 0 0 8px #90c3e4, 0 0 16px #90c3e4;
      ">${text}</h1>`;
    }, text.length * 120 + 1000);
  </script>
</body>
</html>
