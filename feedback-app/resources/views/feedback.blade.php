@extends('layouts.app')

@section('content')
<div class="card shadow p-4 feedback-card mx-auto" style="max-width: 700px;">
  <h2 class="fw-bold mb-4 text-center">Feedback</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('feedback.store') }}" method="POST">
    @csrf

    <!-- Mood Section -->
    <div class="mb-4">
    <label class="form-label fw-semibold">How would you describe your mood after using our product for the first time?</label>
    <div class="row g-3">
        @php
        $moods = [
            'satisfied' => 'fa-face-laugh-beam',
            'good' => 'fa-face-smile',
            'neutral' => 'fa-face-meh',
            'bad' => 'fa-face-frown',
            'unsatisfied' => 'fa-face-angry',
        ];
        @endphp
        @foreach ($moods as $key => $icon)
        <div class="col text-center">
            <input type="radio" class="btn-check" name="mood" value="{{ $key }}" id="mood-{{ $key }}" required>
            <label class="mood-tile" for="mood-{{ $key }}">
            <i class="fas {{ $icon }} fa-2x mb-2"></i>
            <div class="text-capitalize small">{{ $key }}</div>
            </label>
        </div>
        @endforeach
    </div>
    </div>



    <!-- Rating -->
    <div class="mb-4">
      <label class="form-label fw-semibold">How would you rate the quality of our product techvett?</label>
      <div class="d-flex gap-2">
        @for ($i = 1; $i <= 5; $i++)
          <div>
            <input type="radio" class="btn-check" name="rating" value="{{ $i }}" id="rating-{{ $i }}" required>
            <label class="btn btn-outline-primary-custom rating-circle" for="rating-{{ $i }}">
              {{ $i }}
            </label>
          </div>
        @endfor
      </div>
    </div>

    <!-- Features -->
    <div class="mb-4">
      <label class="form-label fw-semibold">Which feature of techvett is best for you?</label>
      @foreach ([
        'Seamless Candidate Test Experience',
        'Real-time Result Transfer to HR Portal',
        'Two-Way Portal Communication & Evaluation Logs'
      ] as $feature)
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature }}" id="{{ Str::slug($feature) }}">
          <label class="form-check-label" for="{{ Str::slug($feature) }}">{{ $feature }}</label>
        </div>
      @endforeach
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
@endsection
