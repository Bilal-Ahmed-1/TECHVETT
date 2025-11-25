<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Replace with actual CSRF token in Laravel -->
  <title>Feedback - Techvett</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #212626;
      color: #90c3e4;
      font-family: 'Roboto', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .feedback-card {
      background-color: #1a1a1a;
      color: #90c3e4;
     border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    padding: 10px;
    -webkit-box-shadow: 9px 13px 7px 5px rgba(0, 0, 0, 0.61);
    -moz-box-shadow: 9px 13px 7px 5px rgba(0,0,0,0.61);
    box-shadow: 9px 13px 7px 5px rgba(0, 0, 0, 0.61);
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
    }

    .btn-outline-primary-custom:hover {
      background-color: #90c3e4 !important;
      color: #212626 !important;
    }

    .btn-check:checked + .btn-outline-primary-custom {
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
<body>
  <div class="card shadow p-4 feedback-card mx-auto" style="max-width: 700px;">
    <h2 class="fw-bold mb-4 text-center">Feedback</h2>

    <!-- Success Message (handled via JavaScript or backend redirect) -->
    <div id="success-message" class="alert alert-success d-none"></div>

    <form id="feedback-form" action="/feedback" method="POST">
      <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}"> <!-- Replace with actual CSRF token -->

      <!-- Mood Section -->
      <div class="mb-4">
        <label class="form-label fw-semibold">How would you describe your mood after using our product for the first time?</label>
        <div class="row g-3">
          <div class="col text-center">
            <input type="radio" class="btn-check" name="mood" value="satisfied" id="mood-satisfied" required>
            <label class="mood-tile" for="mood-satisfied">
              <i class="fas fa-face-laugh-beam fa-2x mb-2"></i>
              <div class="text-capitalize small">Satisfied</div>
            </label>
          </div>
          <div class="col text-center">
            <input type="radio" class="btn-check" name="mood" value="good" id="mood-good" required>
            <label class="mood-tile" for="mood-good">
              <i class="fas fa-face-smile fa-2x mb-2"></i>
              <div class="text-capitalize small">Good</div>
            </label>
          </div>
          <div class="col text-center">
            <input type="radio" class="btn-check" name="mood" value="neutral" id="mood-neutral" required>
            <label class="mood-tile" for="mood-neutral">
              <i class="fas fa-face-meh fa-2x mb-2"></i>
              <div class="text-capitalize small">Neutral</div>
            </label>
          </div>
          <div class="col text-center">
            <input type="radio" class="btn-check" name="mood" value="bad" id="mood-bad" required>
            <label class="mood-tile" for="mood-bad">
              <i class="fas fa-face-frown fa-2x mb-2"></i>
              <div class="text-capitalize small">Bad</div>
            </label>
          </div>
          <div class="col text-center">
            <input type="radio" class="btn-check" name="mood" value="unsatisfied" id="mood-unsatisfied" required>
            <label class="mood-tile" for="mood-unsatisfied">
              <i class="fas fa-face-angry fa-2x mb-2"></i>
              <div class="text-capitalize small">Unsatisfied</div>
            </label>
          </div>
        </div>
      </div>

      <!-- Rating -->
      <div class="mb-4">
        <label class="form-label fw-semibold">How would you rate the quality of our product techvett?</label>
        <div class="d-flex gap-2">
          <div>
            <input type="radio" class="btn-check" name="rating" value="1" id="rating-1" required>
            <label class="btn btn-outline-primary-custom rating-circle" for="rating-1">1</label>
          </div>
          <div>
            <input type="radio" class="btn-check" name="rating" value="2" id="rating-2" required>
            <label class="btn btn-outline-primary-custom rating-circle" for="rating-2">2</label>
          </div>
          <div>
            <input type="radio" class="btn-check" name="rating" value="3" id="rating-3" required>
            <label class="btn btn-outline-primary-custom rating-circle" for="rating-3">3</label>
          </div>
          <div>
            <input type="radio" class="btn-check" name="rating" value="4" id="rating-4" required>
            <label class="btn btn-outline-primary-custom rating-circle" for="rating-4">4</label>
          </div>
          <div>
            <input type="radio" class="btn-check" name="rating" value="5" id="rating-5" required>
            <label class="btn btn-outline-primary-custom rating-circle" for="rating-5">5</label>
          </div>
        </div>
      </div>

      <!-- Features -->
      <div class="mb-4">
        <label class="form-label fw-semibold">Which feature of techvett is best for you?</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="features[]" value="Seamless Candidate Test Experience" id="seamless-candidate-test-experience">
          <label class="form-check-label" for="seamless-candidate-test-experience">Seamless Candidate Test Experience</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="features[]" value="Real-time Result Transfer to HR Portal" id="real-time-result-transfer-to-hr-portal">
          <label class="form-check-label" for="real-time-result-transfer-to-hr-portal">Real-time Result Transfer to HR Portal</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="features[]" value="Two-Way Portal Communication & Evaluation Logs" id="two-way-portal-communication-evaluation-logs">
          <label class="form-check-label" for="two-way-portal-communication-evaluation-logs">Two-Way Portal Communication & Evaluation Logs</label>
        </div>
      </div>

      <!-- Comment -->
      <div class="mb-4">
        <label class="form-label fw-semibold">Your feedback</label>
        <textarea name="comment" rows="3" class="form-control" placeholder="Anything you'd like to add? Your input is valuable to us"></textarea>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-dark-custom w-100">Send Feedback</button>
    </form>
  </div>

  <!-- Bootstrap JS (optional for form interactions) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Axios for form submission -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    document.getElementById('feedback-form').addEventListener('submit', async function (event) {
      event.preventDefault();
      const form = event.target;
      const formData = new FormData(form);
      const successMessage = document.getElementById('success-message');
      
      try {
        const response = await axios.post('/feedback', formData, {
          headers: {
            'X-CSRF-TOKEN': document.getElementById('csrf-token').value,
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        successMessage.textContent = response.data.message || 'Thank you for your feedback!';
        successMessage.classList.remove('d-none');
        form.reset();
        setTimeout(() => {
          successMessage.classList.add('d-none');
        }, 5000);
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Failed to submit feedback. Please try again.';
        successMessage.textContent = errorMessage;
        successMessage.classList.remove('d-none', 'alert-success');
        successMessage.classList.add('alert-danger');
        setTimeout(() => {
          successMessage.classList.add('d-none');
        }, 5000);
      }
    });
  </script>
</body>
</html>