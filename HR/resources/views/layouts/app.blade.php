<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'TECHVETT')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome (Optional) -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      integrity="sha512-Xx..."
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#212626] text-white">
    <div id="app">
        @yield('content')
    </div>
</body>
</html>
