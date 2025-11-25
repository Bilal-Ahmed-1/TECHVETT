<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #212626;
      color: #ffffff;
    }

    .feedback-card {
      background-color: black;
      color: #90c3e4;
      border-radius: 10px;
      box-shadow: black;
    }

    .icon-label i {
      color: #90c3e4;
      transition: transform 0.2s ease;
    }

    .btn-check:checked + .btn .icon-label i {
      transform: scale(1.4);
      color: #212626;
    }

    .btn-dark-custom {
      background-color: #212626;
      color: #ffffff;
    }

    .btn-dark-custom:hover {
      background-color: #90c3e4;
      color: #212626;
      border-color: #212626;
    }

    .form-check-input:checked {
      background-color: #90c3e4;
      border-color: #90c3e4;
    }

    .rating-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    font-size: 14px;
    text-align: center;
    padding: 6px;
    background-color: white;
    color: #212626;
    transition: all 0.2s ease;
    }

    .btn-outline-primary-custom {
    border: 2px solid #90c3e4;
    color: #212626;
    /* background-color: #90c3e4; */
    }

    .btn-outline-primary-custom:hover{
        background-color: #90c3e4 !important;
        color: #212626 !important;
        /* border: 2px solid #212626 !important; */
    }
/* 
    .btn-outline-primary-custom:hover, */
    .btn-check:checked + .btn-outline-primary-custom {
         /* background-color: #90c3e4 !important;
        color: #212626 !important;
        border: 2px solid #212626 !important; */
    background-color: #212626 !important;
  color: #90c3e4 !important;
  border-color: #212626 !important;
    }

    .mood-tile {
  display: block;
  padding: 15px;
  border: 2px solid #90c3e4;
  border-radius: 10px;
  background-color: white;
  color: #212626;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.mood-tile:hover {
  background-color: #90c3e4;
  color: #212626;
}

.btn-check:checked + .mood-tile {
  background-color: #212626;
  color: #90c3e4;
  border-color: #212626;
}

  </style>
</head>
<body class="py-5">
  <div class="container">
    @yield('content')
  </div>
</body>
</html>