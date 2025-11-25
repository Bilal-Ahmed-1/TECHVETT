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
            margin: 0;
            padding: 10px;
            overflow: hidden;
        }
        .container {
            max-width: 500px;
            background: #212626;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            height: auto;
            min-height: 80vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .content {
            text-align: left; /* Changed to left-align the text */
        }
        .header-text {
            margin-bottom: 10px; /* Space between header texts */
        }
        .right-panel {
            color: #90c3e4;
        }
        .form-control {
            background: #333;
            border: none;
            color: #90c3e4;
            height: 38px;
            font-size: 14px;
        }
        .form-control::placeholder {
            color: #aaa;
        }
        .btn-purple {
            background-color: #90c3e4;
            color: black;
            border: none;
            height: 38px;
            font-size: 14px;
        }
        .btn-purple:hover {
            background-color: #5a4ebc;
        }
        .text {
            color: #90c3e4;
            font-size: 14px;
        }
        .text2 {
            text-decoration: none;
            color: #90c3e4;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #90c3e4;
        }
        h2 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #90c3e4;
        }
        p {
            margin-bottom: 10px;
        }
        .mb-3 {
            margin-bottom: 8px !important;
        }
        .alert {
            font-size: 12px;
            padding: 5px;
            margin-bottom: 10px;
        }
        .button-spacer {
            padding-top: 20px; /* Added padding-top before Sign Up button */
        }
        @media (max-width: 768px) {
            .container {
                max-width: 100%;
                min-height: 90vh;
                padding: 10px;
            }
            h1 {
                font-size: 20px;
            }
            h2 {
                font-size: 16px;
            }
            .form-control, .btn-purple {
                height: 36px;
            }
            .button-spacer {
                padding-top: 15px; /* Adjusted for mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header-text">
                <h1 class="fw-bold">CANDIDATE PORTAL</h1>
                <h2 class="fw">Create an Account</h2>
                <p class="text">Already have an account? <a href="{{ route('login') }}" class="text-light text2">Login</a></p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-1">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="text-center">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required value="{{ old('name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="location" class="form-control" placeholder="Location" required value="{{ old('location') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="cnic" class="form-control" placeholder="CNIC" required value="{{ old('cnic') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="number" name="age" class="form-control" placeholder="Age" required value="{{ old('age') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="field" class="form-control" placeholder="Field" required value="{{ old('field') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="qualification" class="form-control" placeholder="Qualification" required value="{{ old('qualification') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="jobrole" class="form-control" placeholder="Job role" required value="{{ old('jobrole') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="experience" class="form-control" placeholder="Experience" required value="{{ old('experience') }}">
                    </div>
                     <div class="col-md-6 mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    </div>
                    <div class="col-md-6 mb-3"></div>
                </div>
                dd($request->all())
                <div class="button-spacer">
                    <button type="submit" class="btn btn-purple w-100 py-2">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>