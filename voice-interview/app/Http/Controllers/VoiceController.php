<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\InterviewResult;

class VoiceController extends Controller
{
    private $questions = [
        "Introduce yourself?",
        "Why did you choose this role?",
        "Can you tell me a technical concept related to Networking or Software Quality Assurance?",
        "Why do you want to join us and why did you leave your last job?",
        "What can you contribute to our company?",
        "Do you lead or follow? Can you work in a team?"
    ];

    public function index()
    {
        return view('interview');
    }

    public function result()
    {
        $field = session('interview_field', 'General');
        $result = InterviewResult::where('field', $field)->latest()->first();

        return view('result', [
            'score' => $result->final_score ?? 'N/A',
            'rating' => $result->rating ?? 'N/A',
        ]);
    }

    public function hrFirst()
    {
        $voiceId = '21m00Tcm4TlvDq8ikWAM';
        $text = "Hi, I'm Sophie, your AI HR interviewer. Before we begin, can you please tell me your field: Software Quality Assurance or Networking and are you ready for the interview?";
        return $this->generateTTS($text, $voiceId);
    }

    public function setField(Request $request)
    {
        $field = $request->input('field');
        if (!in_array($field, ['SQA', 'Networking'])) {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        Session::put('interview_field', $field);
        Session::put('interview_data', []);
        return response()->json(['success' => true]);
    }

    public function speak(Request $request)
{
    Log::info('🎤 speak() triggered');

    if (!$request->hasFile('audio')) {
        return response()->json(['error' => 'No audio uploaded'], 400);
    }

    // Convert audio to WAV
    $audio = $request->file('audio');
    $webmPath = storage_path('app/temp_input.webm');
    $wavPath = storage_path('app/temp_input.wav');
    $audio->move(dirname($webmPath), basename($webmPath));
    exec("ffmpeg -i $webmPath -ar 44100 -ac 1 -f wav $wavPath -y 2>&1");

    // Speech-to-Text
    $stt = Http::withHeaders([
        'xi-api-key' => env('ELEVENLABS_API_KEY')
    ])->asMultipart()->post('https://api.elevenlabs.io/v1/speech-to-text', [
        ['name' => 'file', 'contents' => fopen($wavPath, 'r'), 'filename' => 'temp_input.wav'],
        ['name' => 'model_id', 'contents' => 'scribe_v1'],
        ['name' => 'language_code', 'contents' => 'en'],
    ]);

    @unlink($webmPath);
    @unlink($wavPath);

    if (!$stt->ok()) {
        return response()->json(['error' => 'STT failed'], 500);
    }

    $transcript = $stt->json()['text'] ?? '';
    Log::info('📝 Transcript: ' . $transcript);

    // Save answer in session
    $data = Session::get('interview_data', []);
    $currentQuestion = count($data);

    $data[] = [
        'question' => $this->questions[$currentQuestion],
        'answer' => $transcript
    ];
    Session::put('interview_data', $data);

    // If interview completed
    if (count($data) >= count($this->questions)) {
        return $this->processFinalScoring($data);
    }

        // AI feedback prompt
        $systemPrompt = "
You are a friendly AI interview agent conducting a job interview.

Follow these strict rules step-by-step:

1️⃣ There are 6 fixed questions in a strict order:
- Q1: Introduce yourself?
- Q2: Why did you choose this role?
- Q3: Can you tell me a technical concept related to Networking or Software Quality Assurance?
- Q4: Why do you want to join us and why did you leave your last job?
- Q5: What can you contribute to our company?
- Q6: Do you lead or follow? Can you work in a team?

STRICT RULES:
1️⃣ There are exactly 6 fixed questions asked in strict order like Q1, then Q2, then Q3, then Q4, then Q5, and finally Q6.  
❌ You will NOT ask questions.  
❌ You will NOT repeat questions.  
Laravel will append the next question separately.

2️⃣ For each candidate answer:
- Feedback must be short & natural (use fillers if natural like 'uhm', 'yeah').
- If good: positive feedback.
- If bad: serious/professional feedback.
- If empty: 'Ok, let's move to the next question.'
- Give a **short and polite feedback** (1–2 sentences).
- Do NOT add any question yourself.

3️⃣ DO NOT select or repeat questions yourself from the fixed 6 questions. 
The system will handle the next question. Your only job is to provide feedback.

4️⃣ If the candidate has just answered the **last question (Q6)**, your feedback must end with:
\"Thank you so much for giving the interview wish you best of luck. Now the interview has been completed.\"

5️⃣ You must respond **only in this strict JSON format**:

{
  \"feedback\": \"short polite feedback (and closing if it's the last question)\",
  \"voice_reply\": \"feedback + next question\"
}

6️⃣ Never add extra text or Markdown.
";

        $prompt = $systemPrompt . "\n\nCandidate's answer: \"$transcript\"";

        // Cohere response
        $cohereResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('COHERE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.cohere.ai/v1/generate', [
            'model' => 'command-r-plus',
            'prompt' => $prompt,
            'max_tokens' => 400,
            'temperature' => 0.4
        ]);

        if (!$cohereResponse->ok()) {
            return $this->generateTTS("Sorry, I couldn't process your answer. Please try again.");
        }

        $responseText = trim($cohereResponse->json()['generations'][0]['text'] ?? '');
        if (str_starts_with($responseText, '```json')) {
            $responseText = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $responseText);
        }

        $json = json_decode($responseText, true);
        if (!$json || !isset($json['voice_reply'])) {
            return $this->generateTTS("Sorry, I couldn't process your answer. Please try again.");
        }
    Log::info('🧠 Cohere Parsed Response: ' . json_encode($json, JSON_PRETTY_PRINT));
        return $this->generateTTS($json['voice_reply']);
    }

    private function processFinalScoring($data)
    {
        $fullTranscript = "";
        foreach ($data as $entry) {
            $fullTranscript .= "Question: {$entry['question']}\nAnswer: {$entry['answer']}\n\n";
        }

        // Scoring prompt
        $scoringPrompt = "
You are an expert HR AI system. Based on the following interview transcript, analyze the candidate's overall English proficiency, pronunciation, clarity, confidence, and understanding.

Now generate:

- final_score (1-10)
- rating (Excellent, Good, Average, Poor)

Strict JSON only:

{
  \"final_score\": (integer),
  \"rating\": \"Excellent | Good | Average | Poor\"
}

Transcript:
$fullTranscript
";

        // Call Cohere for scoring
        $cohereResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('COHERE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.cohere.ai/v1/generate', [
            'model' => 'command-r-plus',
            'prompt' => $scoringPrompt,
            'max_tokens' => 400,
            'temperature' => 0.3
        ]);

        if (!$cohereResponse->ok()) {
            return $this->generateTTS("Sorry, I couldn't generate your final score.");
        }

        $responseText = trim($cohereResponse->json()['generations'][0]['text'] ?? '');
        if (str_starts_with($responseText, '```json')) {
            $responseText = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $responseText);
        }

        $json = json_decode($responseText, true);
        if (!$json || !isset($json['final_score']) || !isset($json['rating'])) {
            return $this->generateTTS("Sorry, I couldn't calculate your result.");
        }

        // Save result
        $field = Session::get('interview_field', 'General');
        InterviewResult::create([
            'field' => $field,
            'final_score' => $json['final_score'],
            'rating' => $json['rating'],
            'transcript' => $fullTranscript
        ]);

        // Send TTS + X-Interview-Complete header
        $ttsResponse = $this->generateTTS("Thank you so much for giving the interview wish you best of luck. Now the interview has been completed.");
        return $ttsResponse->header('X-Interview-Complete', 'true');
    }

private function generateTTS(string $text, string $voiceId = '21m00Tcm4TlvDq8ikWAM', bool $raw = false)
{
    $response = Http::withHeaders([
        'xi-api-key' => env('ELEVENLABS_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post("https://api.elevenlabs.io/v1/text-to-speech/{$voiceId}/stream", [
        'text' => $text,
        'model_id' => 'eleven_multilingual_v2',
        'voice_settings' => [
            'stability' => 0.5,
            'similarity_boost' => 0.5
        ]
    ]);

    if (!$response->ok()) {
        Log::error('🔇 TTS failed', ['status' => $response->status()]);
        return response()->json(['error' => 'TTS failed'], $response->status());
    }

    if ($raw) {
        return $response->body();
    }

    return response($response->body(), 200)
        ->header('Content-Type', 'audio/mpeg');
}

}