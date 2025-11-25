<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHVETT</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #212626;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }
        .container {
            margin:0;
            padding:0;
            max-width: 900px;
            background: #212626;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: row;
        }
        .left-panel {
            width: 50%;
            padding: 40px;
            color: #90c3e4;
        }
        .right-panel {
            width: 50%;
            background: url('{{ asset("images/back.jpg") }}') no-repeat center;
            background-size: cover;
            border-radius: 0 15px 15px 0;
        }
        .form-control {
            background: #333;
            border: none;
            color: #90c3e4;
        }
        .form-control::placeholder {
            color: #aaa;
        }
        .btn-purple {
            background-color: #90c3e4;
            color: black;
            border: none;
        }
        .btn-purple:hover {
            background-color: #5a4ebc;
        }
        .text {
            color: #90c3e4;
        }
        .text2 {
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .right-panel {
                width: 100%;
                height: 200px;
            }
            .left-panel {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1 class="fw-bold">HR PORTAL</h1>
            <h2 class="fw">Login</h2>
            <p class="text">Don't have an account? <a href="{{ route('register') }}" class="text-light text2">Sign up</a></p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-purple w-100 py-2">Login</button>
            </form>

            <!-- <div class="mt-4 text-center">
                <button class="btn btn-outline-light w-100 mb-2">
                    <img src="{{ asset('images/icon1.png') }}" width="20" class="me-2"> Login with Google
                </button>
                <button class="btn btn-outline-light w-100">
                    <img src="{{ asset('images/icon2.png') }}" width="20" class="me-2"> Login with Apple
                </button>
            </div> -->
        </div>

        <div class="right-panel d-none d-md-block"></div>
    </div>

</body>
</html>