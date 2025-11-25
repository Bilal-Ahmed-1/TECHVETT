<template>
  <div class="quiz-container">
    <!-- Disclaimer Page -->
    <div v-if="showDisclaimer">
      <div class="text-center">
        <div class="container d-flex justify-content-center">
          <div class="card">
            <h1 class="heartbeat-animation">DISCLAIMER</h1>
            <div class="left">
              <p>Following are the things you need to know before proceeding further:</p>
              <p>The test consists of 2 fields:</p>
              <p>I. Network</p>
              <p>II. SQA</p>
              <p>Each field has 3 stages based on experience levels:</p>
              <p>I. Basic (0 to 6 months)</p>
              <p>II. Intermediate (7 months to 1.5 years)</p>
              <p>III. Advanced (2 to 5 years)</p>
              <p><i class="fa-regular fa-circle-dot"></i> First Stage: MCQ-based "QUESTIONS"</p>
              <p><i class="fa-regular fa-circle-dot"></i> Second Stage: Image-based answer guessing</p>
              <p><i class="fa-regular fa-circle-dot"></i> Third Stage: Voice-over voice analysis</p>
            </div>
            <div class="btn-display">
              <button type="button" class="btn2 button-30" @click="dismissDisclaimer">
                Next <i class="fa-solid fa-diamond"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Category Selection -->
    <div v-else-if="!categorySelected">
      <category-selection ref="categorySelection" :categories="categories" :loading="loading" @category-selected="onCategorySelected" />
    </div>

    <!-- Level Selection -->
    <div v-else-if="!levelSelected">
      <level-selection ref="levelSelection" :levels="levels" :loading="loading" @level-selected="onLevelSelected" />
    </div>

    <!-- Stage 2 Information Page -->
    <div v-else-if="showStage2Info">
      <div class="text-center">
        <div class="container d-flex justify-content-center">
          <div class="card">
            <h1 class="heartbeat-animation">Image Based Quiz</h1>
            <div class="left">
              <p>Welcome to Stage 2 of the quiz!</p>
              <p>In this stage, you will be presented with images related to your selected category and level.</p>
              <p>For each question:</p>
              <p><i class="fa-regular fa-circle-dot"></i> Analyze the provided image.</p>
              <p><i class="fa-regular fa-circle-dot"></i> Select the correct option from MCQ's.</p>
              <p><i class="fa-regular fa-circle-dot"></i> Provide a brief reasoning for your selection.</p>
              <p>Click the Start button to begin Stage 2.</p>
            </div>
            <div class="btn-display">
              <button type="button" class="btn2 button-30" @click="startStage2" :disabled="loading">
                Start Stage 2 <i class="fa-solid fa-diamond"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stage 3 Information Page -->
    <div v-else-if="showStage3Info">
      <div class="text-center">
        <div class="container d-flex justify-content-center">
          <div class="card">
            <h1 class="heartbeat-animation">Voice over Voice Analysis</h1>
            <div class="left">
              <p>Welcome to Stage 3 of the quiz!</p>
              <p>In this stage, you will participate in a voice-based interview analysis:</p>
              <p><i class="fa-regular fa-circle-dot"></i> You will be asked to respond to questions verbally.</p>
              <p><i class="fa-regular fa-circle-dot"></i> Your responses will be recorded and analyzed.</p>
              <p><i class="fa-regular fa-circle-dot"></i> Please ensure a quiet space and working microphone.</p>
              <p>Click the Start button to begin Stage 3.</p>
            </div>
            <div class="btn-display">
              <button type="button" class="btn2 button-30" @click="startStage3" :disabled="loading">
                Start Stage 3 <i class="fa-solid fa-diamond"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stage 2 Image-Based Quiz -->
    <div v-else-if="stage === 2">
      <div v-if="currentStage2">
        <div class="card">
          <h3 style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 24px; text-align: center; margin: 0 0 15px 0;">
            Question {{ currentStage2Index + 1 }} of {{ stage2Questions.length }}
          </h3>
          <p style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 18px; text-align: center; margin: 0 0 20px 0;">{{ currentStage2.question_text }}</p>
          <div style="display: flex; align-items: flex-start; gap: 20px;">
            <div class="image-container" style="min-height: 350px; flex: 1; display: flex; justify-content: center; align-items: center; margin-bottom: 25px;">
              <img :src="`/images/${currentStage2.image_path}`" alt="Question Image" class="img-fluid" @error="onImageError" style="width: 85%; height: auto; border: 2px solid #09c3e4; border-radius: 5px;" />
            </div>
            <div style="flex: 1;">
              <div class="options-list" style="margin-bottom: 25px;">
                <div v-for="option in currentStage2.options" :key="option.id" class="option-item" style="margin-bottom: 12px;">
                  <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="radio" :value="option.id" v-model="selectedOption" class="option-input" />
                    <span style="display: inline-flex; align-items: center; padding: 6px 15px; border-radius: 20px; background: #1a1a1a; color: #09c3e4; width: 100%; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 20px;">
                      {{ option.option_text }}
                    </span>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="reason-box" style="margin-bottom: 25px;">
            <label for="reason" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px; display: block; margin-bottom: 8px;">Reason:</label>
            <textarea id="reason" v-model="reasoning" rows="4" style="width: 100%; padding: 12px; border: 2px solid #09c3e4; border-radius: 10px; background: #1a1a1a; color: #09c3e4; resize: vertical; font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;" placeholder="Explain your reasoning here..."></textarea>
          </div>
          <div class="btn-display">
            <button @click="submitStage2Answer" class="btn2 button-30" :disabled="loading || !selectedOption || !reasoning">
              {{ currentStage2Index + 1 === stage2Questions.length ? 'Proceed to Stage 3' : 'Submit Answer' }} <i class="fa-solid fa-diamond"></i>
            </button>
          </div>
          <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
      </div>
      <div v-else>
        <div class="card">
          <h2 style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">Loading Stage 2 Questions and images...</h2>
          <div class="btn-display">
            <button class="btn2 button-30" :disabled="loading">
              Proceed to Stage 3... <i class="fa-solid fa-diamond"></i>
            </button>
          </div>
          <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
      </div>
    </div>

    <!-- Stage 3 Voice Analysis -->
    <div v-else-if="stage === 3">
      <div id="particles-js"></div>
      <div id="floating-blobs">
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
      </div>
      <div class="techvett-brand">TECHVETT</div>
      <div class="heading">Stage 3: Voice over Voice Analysis</div>
      <div class="card">
        <div id="status">{{ statusText }}</div>
        <div class="mic-wrapper">
          <div class="mic-ring" id="micRing"></div>
          <button id="start" @click="startRecording">🎤</button>
        </div>
        <div id="waveform" :class="{ 'visible': isRecording }">
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="wave"></div>
          <div class="wave"></div>
        </div>
        <div class="shimmer mt-4">AI Interviewing Now...</div>
        <div class="d-flex justify-content-end mt-4">
          <button id="doneBtn" class="btn btn-dark-custom px-4 py-2 fw-bold" :style="{ display: showDoneButton ? 'block' : 'none' }" @click="goToFeedback">
            ✅ Done
          </button>
        </div>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      </div>
    </div>

    <!-- Feedback Form -->
    <div v-else-if="stage === 4">
      <div class="card feedback-card">
        <h2 class="fw-bold heartbeat-animation mb-4 text-center">Feedback</h2>
        <div v-if="feedbackMessage" :class="['alert', feedbackMessageType === 'success' ? 'alert-success' : 'alert-danger']">
          {{ feedbackMessage }}
        </div>
        <form id="feedback-form" @submit.prevent="submitFeedback">
          <!-- Mood Section -->
          <div class="mb-4">
            <label class="form-label fw-semibold">How would you describe your mood after using our product for the first time?</label>
            <div class="row g-3">
              <div class="col text-center">
                <input type="radio" class="btn-check" name="mood" value="satisfied" id="mood-satisfied" v-model="feedback.mood" required>
                <label class="mood-tile" for="mood-satisfied">
                  <i class="fas fa-face-laugh-beam fa-2x mb-2"></i>
                  <div class="text-capitalize small">Satisfied</div>
                </label>
              </div>
              <div class="col text-center">
                <input type="radio" class="btn-check" name="mood" value="good" id="mood-good" v-model="feedback.mood" required>
                <label class="mood-tile" for="mood-good">
                  <i class="fas fa-face-smile fa-2x mb-2"></i>
                  <div class="text-capitalize small">Good</div>
                </label>
              </div>
              <div class="col text-center">
                <input type="radio" class="btn-check" name="mood" value="neutral" id="mood-neutral" v-model="feedback.mood" required>
                <label class="mood-tile" for="mood-neutral">
                  <i class="fas fa-face-meh fa-2x mb-2"></i>
                  <div class="text-capitalize small">Neutral</div>
                </label>
              </div>
              <div class="col text-center">
                <input type="radio" class="btn-check" name="mood" value="bad" id="mood-bad" v-model="feedback.mood" required>
                <label class="mood-tile" for="mood-bad">
                  <i class="fas fa-face-frown fa-2x mb-2"></i>
                  <div class="text-capitalize small">Bad</div>
                </label>
              </div>
              <div class="col text-center">
                <input type="radio" class="btn-check" name="mood" value="unsatisfied" id="mood-unsatisfied" v-model="feedback.mood" required>
                <label class="mood-tile" for="mood-unsatisfied">
                  <i class="fas fa-face-angry fa-2x mb-2"></i>
                  <div class="text-capitalize small">Unsatisfied</div>
                </label>
              </div>
            </div>
          </div>

          <!-- Rating -->
          <div class="mb-4">
            <label class="form-label fw-semibold">How would you rate the quality of our product Techvett?</label>
            <div class="d-flex gap-2 justify-content-center">
              <div v-for="i in 5" :key="i">
                <input type="radio" class="btn-check" name="rating" :value="i" :id="`rating-${i}`" v-model="feedback.rating" required>
                <label class="btn btn-outline-primary-custom rating-circle" :for="`rating-${i}`">{{ i }}</label>
              </div>
            </div>
          </div>

          <!-- Features -->
          <div class="mb-4">
            <label class="form-label fw-semibold">Which feature of Techvett is best for you?</label>
            <div v-for="feature in features" :key="feature.id" class="form-check">
              <input class="form-check-input" type="checkbox" :value="feature.value" :id="feature.id" v-model="feedback.features">
              <label class="form-check-label" :for="feature.id">{{ feature.label }}</label>
            </div>
          </div>

          <!-- Comment -->
          <div class="mb-4">
            <label class="form-label fw-semibold">Your feedback</label>
            <textarea v-model="feedback.comment" rows="3" class="form-control" placeholder="Anything you'd like to add? Your input is valuable to us"></textarea>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-dark-custom w-100" :disabled="feedbackLoading">Send Feedback</button>
        </form>
      </div>
    </div>

    <!-- Stage 1 MCQ Quiz -->
    <div v-else-if="stage === 1" class="quiz-section">
      <div v-if="currentQuestion">
        <div class="card">
          <h3 style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 24px; text-align: center; margin: 0 0 15px 0;">
            Question {{ currentIndex + 1 }} of {{ questions.length }}
          </h3>
          <p class="question-text" style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 18px; text-align: center; margin: 0 0 20px 0;">{{ currentQuestion.question_text }}</p>
          <div class="options-list">
            <div v-for="option in currentQuestion.options" :key="option.id" class="option-item">
              <label>
                <input type="radio" :value="option.id" v-model="selectedOption" class="option-input" />
                <span style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 20px;">{{ option.option_text }}</span>
              </label>
            </div>
          </div>
          <div class="btn-display">
            <button @click="submitAnswer" class="btn2 button-30" :disabled="loading || !selectedOption">
              {{ currentIndex + 1 === questions.length ? 'Finish Stage 1' : 'Submit Answer' }} <i class="fa-solid fa-diamond"></i>
            </button>
          </div>
          <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
      </div>
      <div v-else>
        <div class="card">
          <h2 style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">Quiz is Starting</h2>
          <div class="btn-display">
            <button @click="goToStage2Info" class="btn2 button-30" :disabled="loading">
              Proceed to Stage 1 <i class="fa-solid fa-diamond"></i>
            </button>
          </div>
          <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CategorySelection from './CategorySelection.vue';
import LevelSelection from './LevelSelection.vue';

export default {
  components: {
    CategorySelection,
    LevelSelection,
  },
  data() {
    return {
      showDisclaimer: true,
      stage: 1,
      categorySelected: false,
      levelSelected: false,
      loading: false,
      showStage2Info: false,
      showStage3Info: false,
      errorMessage: '',
      testId: null,
      category: null,
      level: null,
      categories: [],
      levels: [],
      questions: [],
      currentQuestion: null,
      currentIndex: 0,
      selectedOption: null,
      reasoning: '',
      stage2Questions: [],
      currentStage2: null,
      currentStage2Index: 0,
      submittedAnswers: [],
      statusText: 'Press the button to start',
      isRecording: false,
      showDoneButton: false,
      mediaRecorder: null,
      audioChunks: [],
      feedback: {
        mood: null,
        rating: null,
        features: [],
        comment: '',
      },
      feedbackMessage: '',
      feedbackMessageType: 'success',
      feedbackLoading: false,
      features: [
        { id: 'seamless-candidate-test-experience', value: 'Seamless Candidate Test Experience', label: 'Seamless Candidate Test Experience' },
        { id: 'real-time-result-transfer-to-hr-portal', value: 'Real-time Result Transfer to HR Portal', label: 'Real-time Result Transfer to HR Portal' },
        { id: 'two-way-portal-communication-evaluation-logs', value: 'Two-Way Portal Communication & Evaluation Logs', label: 'Two-Way Portal Communication & Evaluation Logs' },
      ],
    };
  },
  async mounted() {
    this.loading = true;
    try {
      const token = localStorage.getItem('auth_token');
      if (!token) {
        this.$router.push('/login');
        return;
      }
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      const [categoriesResponse, levelsResponse] = await Promise.all([
        axios.get('/api/categories'),
        axios.get('/api/levels'),
      ]);
      this.categories = Array.isArray(categoriesResponse.data) ? categoriesResponse.data : [];
      this.levels = Array.isArray(levelsResponse.data) ? levelsResponse.data : [];
      if (!this.categories.length || !this.levels.length) {
        throw new Error('Invalid categories or levels data');
      }
      // Initialize particles.js and floating particles for Stage 3
      this.initParticlesJS();
      this.initFloatingParticles();
      // Fetch CSRF token
      await this.fetchCsrfToken();
    } catch (error) {
      this.errorMessage = 'Failed to load categories or levels. Please try again.';
      this.$router.push('/login');
    } finally {
      this.loading = false;
    }
  },
  methods: {
    async fetchCsrfToken() {
      try {
        const response = await axios.get('/csrf-token');
        this.csrfToken = response.data.csrf_token;
      } catch (error) {
        console.error('Failed to fetch CSRF token:', error);
      }
    },
    dismissDisclaimer() {
      this.showDisclaimer = false;
    },
    onCategorySelected(categoryId) {
      this.category = categoryId;
      this.categorySelected = true;
      this.errorMessage = '';
    },
    onLevelSelected(levelId) {
      this.level = levelId;
      this.levelSelected = true;
      this.startQuiz();
    },
    async startQuiz() {
      this.loading = true;
      this.errorMessage = '';
      try {
        const response = await axios.post('/api/start-quiz', {
          category_id: this.category,
          level_id: this.level,
        });
        this.testId = response.data.test_id;
        await this.fetchQuestions();
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Failed to start the quiz. Please try again.';
        console.error('Start quiz error:', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchQuestions() {
      this.loading = true;
      this.errorMessage = '';
      try {
        const response = await axios.get(`/api/questions/${this.testId}`);
        this.questions = Array.isArray(response.data) ? response.data.slice(0, 15) : [];
        this.currentQuestion = this.questions[this.currentIndex] || null;
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Failed to load questions. Please try again.';
        console.error('Fetch questions error:', error);
      } finally {
        this.loading = false;
      }
    },
    async submitAnswer() {
      if (!this.selectedOption) {
        this.errorMessage = 'Please select an option.';
        return;
      }
      this.loading = true;
      this.errorMessage = '';
      try {
        await axios.post('/api/submit-answer', {
          question_id: this.currentQuestion.id,
          option_id: this.selectedOption,
        });
        this.selectedOption = null;
        if (this.currentIndex + 1 < this.questions.length) {
          this.currentIndex++;
          this.currentQuestion = this.questions[this.currentIndex];
        } else {
          await this.fetchStage1Result();
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Error submitting answer. Please try again.';
        console.error('Submit answer error:', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchStage1Result() {
      this.loading = true;
      this.errorMessage = '';
      try {
        await axios.get(`/api/quiz-result/${this.testId}`);
        this.currentQuestion = null;
        this.goToStage2Info();
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Failed to load Stage 1 results. Proceeding to Stage 2.';
        console.error('Fetch Stage 1 result error:', error);
        this.currentQuestion = null;
        this.goToStage2Info();
      } finally {
        this.loading = false;
      }
    },
    goToStage2Info() {
      this.showStage2Info = true;
      this.stage = 1;
    },
    async startStage2() {
      this.stage = 2;
      this.showStage2Info = false;
      this.submittedAnswers = [];
      this.currentStage2Index = 0;
      this.stage2Questions = [];
      this.loading = true;
      this.errorMessage = '';
      try {
        await this.fetchNextStage2Question();
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Failed to start Stage 2. Please try again.';
        console.error('Start Stage 2 error:', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchNextStage2Question() {
      this.loading = true;
      this.errorMessage = '';
      try {
        const response = await axios.get(`/api/stage2/question/${this.testId}`);
        if (response.data && response.data.questions && Array.isArray(response.data.questions)) {
          this.stage2Questions = response.data.questions.map(question => ({
            id: question.id,
            image_path: question.image_path || 'default.jpg',
            question_text: question.question_text,
            options: [
              { id: 1, option_text: question.option_1 },
              { id: 2, option_text: question.option_2 },
              { id: 3, option_text: question.option_3 },
              { id: 4, option_text: question.option_4 },
              { id: 5, option_text: question.option_5 },
            ].filter(option => option.option_text),
          }));
          if (this.stage2Questions.length === 0) {
            throw new Error('No Stage 2 questions available for the selected category and level');
          }
          this.currentStage2Index = 0;
          this.currentStage2 = this.stage2Questions[this.currentStage2Index];
        } else {
          throw new Error('Invalid Stage 2 questions data');
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Error fetching Stage 2 questions. Please try again.';
        console.error('Fetch Stage 2 questions error:', error);
        this.goToStage3Info();
      } finally {
        this.loading = false;
      }
    },
    async submitStage2Answer() {
      if (!this.selectedOption) {
        this.errorMessage = 'Please select an option.';
        return;
      }
      if (!this.reasoning.trim()) {
        this.errorMessage = 'Please provide a reason for your selection.';
        return;
      }
      this.loading = true;
      this.errorMessage = '';
      try {
        const selectedOptionObj = this.currentStage2.options.find(opt => opt.id === parseInt(this.selectedOption));
        const selectedOptionText = selectedOptionObj ? selectedOptionObj.option_text : 'Unknown';
        this.submittedAnswers.push({
          question_id: this.currentStage2.id,
          question_text: this.currentStage2.question_text,
          selected_option: parseInt(this.selectedOption),
          selected_option_text: selectedOptionText,
          reason: this.reasoning.trim(),
        });
        await axios.post('/api/stage2/submit', {
          question_id: this.currentStage2.id,
          selected_option: parseInt(this.selectedOption),
          reason: this.reasoning.trim(),
        });
        this.selectedOption = null;
        this.reasoning = '';
        this.currentStage2Index++;
        if (this.currentStage2Index < this.stage2Questions.length && this.stage2Questions[this.currentStage2Index]) {
          this.currentStage2 = this.stage2Questions[this.currentStage2Index];
        } else {
          this.currentStage2 = null;
          await this.fetchStage2Result();
          this.goToStage3Info();
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Error submitting Stage 2 response. Please try again.';
        console.error('Submit Stage 2 error:', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchStage2Result() {
      this.loading = true;
      this.errorMessage = '';
      try {
        await axios.get('/api/stage2/result');
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Failed to load Stage 2 results.';
        console.error('Fetch Stage 2 result error:', error);
      } finally {
        this.loading = false;
      }
    },
    goToStage3Info() {
      this.showStage3Info = true;
      this.stage = 2;
    },
    async startStage3() {
      this.stage = 3;
      this.showStage3Info = false;
      this.loading = true;
      this.errorMessage = '';
      try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        this.mediaRecorder = new MediaRecorder(stream);
        this.audioChunks = [];
        this.mediaRecorder.ondataavailable = (event) => {
          if (event.data.size > 0) {
            this.audioChunks.push(event.data);
          }
        };
        this.mediaRecorder.onstop = async () => {
          const audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
          const formData = new FormData();
          formData.append('audio', audioBlob, 'recording.webm');
          formData.append('test_id', this.testId);
          try {
            await axios.post('/api/stage3/submit', formData, {
              headers: { 'Content-Type': 'multipart/form-data' }
            });
            this.showDoneButton = true;
            this.statusText = 'Recording submitted successfully!';
          } catch (error) {
            this.errorMessage = error.response?.data?.message || 'Error submitting Stage 3 recording.';
            console.error('Submit Stage 3 error:', error);
          }
        };
        // Simulate AI interaction
        this.statusText = 'AI Listening...';
        setTimeout(() => {
          this.statusText = 'AI Speaking...';
        }, 2500);
        setTimeout(() => {
          this.statusText = 'Interaction complete';
          this.isRecording = false;
          this.showDoneButton = true;
        }, 6000);
      } catch (error) {
        this.errorMessage = 'Failed to access microphone. Please check permissions and try again.';
        console.error('Start Stage 3 error:', error);
      } finally {
        this.loading = false;
      }
    },
    startRecording() {
      if (!this.mediaRecorder) {
        this.errorMessage = 'Media recorder not initialized.';
        return;
      }
      if (this.isRecording) {
        this.mediaRecorder.stop();
        this.isRecording = false;
        this.statusText = 'Recording stopped. Processing...';
      } else {
        this.audioChunks = [];
        this.mediaRecorder.start();
        this.isRecording = true;
        this.statusText = 'Recording... Speak clearly.';
        document.getElementById('waveform').style.visibility = 'visible';
        setTimeout(() => {
          this.statusText = 'AI Listening...';
        }, 1000);
        setTimeout(() => {
          this.statusText = 'AI Speaking...';
        }, 3500);
        setTimeout(() => {
          this.statusText = 'Interaction complete';
          this.isRecording = false;
          document.getElementById('waveform').style.visibility = 'hidden';
          this.showDoneButton = true;
        }, 6000);
      }
    },
    goToFeedback() {
      this.stage = 4;
      this.feedbackMessage = '';
      this.feedback = { mood: null, rating: null, features: [], comment: '' };
    },
    async submitFeedback() {
  if (!this.feedback.mood || !this.feedback.rating) {
    this.feedbackMessage = 'Please select a mood and rating.';
    this.feedbackMessageType = 'error';
    return;
  }
  this.feedbackLoading = true;
  this.feedbackMessage = '';
  try {
    // Submit feedback
    const feedbackResponse = await axios.post('/feedback', {
      _token: this.csrfToken,
      mood: this.feedback.mood,
      rating: this.feedback.rating,
      features: this.feedback.features,
      comment: this.feedback.comment,
      test_id: this.testId,
    }, {
      headers: { 'X-CSRF-TOKEN': this.csrfToken }
    });
    this.feedbackMessage = feedbackResponse.data.message || 'Thank you for your feedback!';
    this.feedbackMessageType = 'success';
    this.feedback = { mood: null, rating: null, features: [], comment: '' };

    // Call update-test-scores endpoint
    await axios.get('/update-test-scores');

    // Navigate to quiz
    if (this.$router) {
      console.log('Navigating to /quiz using Vue Router');
      this.$router.push('/quiz');
    } else {
      console.warn('Vue Router is undefined, using window.location.href');
      window.location.href = '/quiz';
    }
  } catch (error) {
    console.error('Feedback submission or score update failed:', {
      message: error.message,
      response: error.response ? {
        status: error.response.status,
        data: error.response.data
      } : null,
      request: error.request ? error.request : null
    });
    const errorMessage = error.response?.data?.message || error.message;
    if (errorMessage.includes('CSRF')) {
      this.feedbackMessage = 'Session expired. Please refresh and try again.';
    } else {
      this.feedbackMessage = `Failed to submit feedback or update scores: ${errorMessage}`;
    }
    this.feedbackMessageType = 'error';
    setTimeout(() => {
      this.feedbackMessage = '';
    }, 5000);
  } finally {
    this.feedbackLoading = false;
  }
},
    restartQuiz() {
      this.showDisclaimer = true;
      this.stage = 1;
      this.categorySelected = false;
      this.levelSelected = false;
      this.showStage2Info = false;
      this.showStage3Info = false;
      this.errorMessage = '';
      this.testId = null;
      this.category = null;
      this.level = null;
      this.questions = [];
      this.currentQuestion = null;
      this.currentIndex = 0;
      this.selectedOption = null;
      this.reasoning = '';
      this.stage2Questions = [];
      this.currentStage2 = null;
      this.currentStage2Index = 0;
      this.submittedAnswers = [];
      this.statusText = 'Press the button to start';
      this.isRecording = false;
      this.showDoneButton = false;
      this.mediaRecorder = null;
      this.audioChunks = [];
      this.feedback = { mood: null, rating: null, features: [], comment: '' };
      this.feedbackMessage = '';
    },
    onImageError(event) {
      event.target.src = '/images/default.jpg';
    },
    initParticlesJS() {
      if (window.particlesJS) {
        window.particlesJS('particles-js', {
          particles: {
            number: { value: 60 },
            color: { value: '#09c3e4' },
            shape: { type: 'circle' },
            opacity: { value: 0.2 },
            size: { value: 3, random: true },
            move: { enable: true, speed: 1.2, direction: 'none', out_mode: 'out' },
          },
          interactivity: { events: { onhover: { enable: true, mode: 'repulse' } } },
          retina_detect: true,
        });
      }
    },
    initFloatingParticles() {
      for (let i = 0; i < 15; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.animationDuration = `${6 + Math.random() * 4}s`;
        document.body.appendChild(particle);
      }
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap");

.quiz-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  /* background-color: #1a1a1a; */
}

body {
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 16px;
  animation: transitionIn 0.75s;
}

p {
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 24px;
  margin-top: 0;
  margin-bottom: 1rem;
  color: #09c3e4;
}

.card {
  color: #09c3e4;
  background: #1a1a1a;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.18);
  padding: 30px;
  box-shadow: 9px 13px 7px 5px rgba(0, 0, 0, 0.61);
  width: 1000px;
}

.feedback-card {
  max-width: 700px;
}

.left {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 12px;
}

@keyframes transitionIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

h1.heartbeat-animation {
  font-family: "Roboto Mono", monospace;
  font-weight: 700;
  font-size: 30px;
  color: #09c3e4;
  text-align: center;
  display: block;
  margin: 0 auto;
  animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
  0% {
    transform: scale(1);
    text-shadow: 0 0 5px rgba(9, 195, 228, 0.5);
  }
  50% {
    transform: scale(1.1);
    text-shadow: 0 0 10px rgba(9, 195, 228, 0.8);
  }
  100% {
    transform: scale(1);
    text-shadow: 0 0 5px rgba(9, 195, 228, 0.5);
  }
}

input[type="radio"] {
  display: none;
}

label {
  display: block;
  cursor: pointer;
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 16px;
  margin-bottom: 10px;
}

label span {
  display: inline-flex;
  align-items: center;
  padding: 10px 20px 10px 10px;
  border-radius: 31px;
  transition: 0.25s ease;
}

label span:hover,
input[type="radio"]:checked + span {
  background-color: #212626;
  border: 2px solid #09c3e4;
}

label span:before {
  content: "";
  background-color: #212626;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  margin-right: 12px;
  transition: 0.3s ease;
  box-shadow: inset 0 0 0 2px #09c3e4;
}

input[type="radio"]:checked + span:before {
  background-color: #09c3e4;
}

.btn2.button-30 {
  margin-top: 20px;
  padding: 14px 28px;
  font-size: 16px;
  color: #09c3e4;
  background: none;
  border: none;
  position: relative;
  cursor: pointer;
  font-family: 'Roboto Mono', monospace;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: color 0.3s ease;
}

.btn2.button-30::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -4px;
  width: 0;
  height: 2px;
  background-color: #09c3e4;
  transition: width 0.3s ease;
}

.btn2.button-30:hover:not(:disabled) {
  color: #ffffff;
  text-shadow: 0 0 8px rgba(9, 195, 228, 0.5);
}

.btn2.button-30:hover::after {
  width: 100%;
}

.btn2.button-30:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  color: #09c3e4;
}

.btn2.button-30:disabled::after {
  width: 0;
}

.btn-display {
  display: flex;
  justify-content: flex-end;
  padding-right: 25px;
  padding-bottom: 25px;
}

.container {
  width: 800px;
  max-width: 90%;
  background-color: #212626;
  border-radius: 10px;
  overflow: hidden;
}

.image-container img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

.mcq-container {
  flex: 1;
  padding: 40px;
  background: #212626;
}

.options-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.option-item {
  display: flex;
  align-items: center;
}

.reason {
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 16px;
  margin-top: 10px;
  display: flex;
}

.result-item {
  margin-bottom: 20px;
  border-bottom: 1px solid #09c3e4;
  padding-bottom: 10px;
}

.error {
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 16px;
  color: red;
  text-align: center;
  margin-top: 10px;
}

/* Stage 3 Styles */
.techvett-brand {
  position: fixed;
  top: 18px;
  left: 28px;
  font-size: 1.6rem;
  font-weight: 600;
  letter-spacing: 1px;
  background: linear-gradient(90deg, #09c3e4, #1a1a1a, #09c3e4);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: fadeShimmer 8s ease-in-out infinite;
  z-index: 99;
}

@keyframes fadeShimmer {
  0%, 100% { opacity: 0; background-position: 0% center; }
  50% { opacity: 1; background-position: 100% center; }
}

#particles-js,
#floating-blobs {
  position: fixed;
  width: 100%;
  height: 100%;
  z-index: -2;
}

#floating-blobs {
  z-index: -1;
}

.particle {
  position: fixed;
  top: -10px;
  width: 8px;
  height: 8px;
  background: radial-gradient(circle, #09c3e4, transparent);
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
  background: radial-gradient(circle, rgba(9, 195, 228, 0.6), rgba(9, 195, 228, 0.1));
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
  margin-top: 13px;
  color: #09c3e4;
}

#status {
  font-family: "Roboto", sans-serif;
  font-weight: 400;
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
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 60px;
  border: none;
  color: #09c3e4;
  background: #1a1a1a;
  position: absolute;
  top: 15px;
  left: 15px;
  z-index: 10;
  cursor: pointer;
}

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
  0% { box-shadow: 0 0 6px #09c3e4, 0 0 12px #09c3e4, 0 0 30px #09c3e4; }
  50% { box-shadow: 0 0 8px #09c3e4, 0 0 20px #09c3e4, 0 0 40px #09c3e4; }
  100% { box-shadow: 0 0 6px #09c3e4, 0 0 12px #09c3e4, 0 0 30px #09c3e4; }
}

#waveform {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 60px;
  margin-top: 40px;
  gap: 4px;
  visibility: hidden;
}

#waveform.visible {
  visibility: visible;
}

.wave {
  width: 4px;
  border-radius: 5px;
  animation: waveAnim 1.2s ease-in-out infinite, waveGlow 4s ease-in-out infinite;
  background: linear-gradient(to top, #09c3e4, #1a1a1a);
}

@keyframes waveAnim {
  0%, 100% { height: 20px; }
  50% { height: 60px; }
}

@keyframes waveGlow {
  0% { background: linear-gradient(to top, #09c3e4, #1a1a1a); }
  50% { background: linear-gradient(to top, #1a1a1a, #09c3e4); }
  100% { background: linear-gradient(to top, #09c3e4, #1a1a1a); }
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
  font-family: "Roboto", sans-serif;
  font-weight: 400;
  font-size: 16px;
  text-align: center;
  border-radius: 16px;
  background: linear-gradient(135deg, #1a1a1a, #09c3e4, #1a1a1a);
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

.btn-dark-custom {
  background-color: #1a1a1a;
  color: #09c3e4;
  border: 2px solid #09c3e4;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.3s ease;
}

.btn-dark-custom:hover {
  background-color: #09c3e4;
  color: #1a1a1a;
  border-color: #1a1a1a;
}

.btn-dark-custom:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.form-label {
  font-weight: 400;
  font-size: 16px;
  color: #09c3e4;
}

.mood-tile {
  display: block;
  padding: 15px;
  border: 2px solid #09c3e4;
  border-radius: 10px;
  background-color: #1a1a1a;
  color: #09c3e4;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  text-align: center;
}

.mood-tile:hover {
  background-color: #09c3e4;
  color: #1a1a1a;
}

.btn-check:checked + .mood-tile {
  background-color: #09c3e4;
  color: #1a1a1a;
  border-color: #09c3e4;
}

.mood-tile i {
  color: #09c3e4;
  transition: transform 0.2s ease;
}

.btn-check:checked + .mood-tile i {
  transform: scale(1.4);
  color: #1a1a1a;
}

.rating-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  padding: 6px;
  background-color: #1a1a1a;
  color: #09c3e4;
  border: 2px solid #09c3e4;
  transition: all 0.2s ease;
}

.rating-circle:hover {
  background-color: #09c3e4;
  color: #1a1a1a;
}

.btn-check:checked + .rating-circle {
  background-color: #09c3e4;
  color: #1a1a1a;
  border-color: #09c3e4;
}

.form-check-input:checked {
  background-color: #09c3e4;
  border-color: #09c3e4;
}

.form-control {
  background-color: #1a1a1a;
  color: #09c3e4;
  border: 2px solid #09c3e4;
  border-radius: 10px;
}

.form-control:focus {
  background-color: #1a1a1a;
  color: #09c3e4;
  border-color: #09c3e4;
  box-shadow: 0 0 5px #09c3e4;
}

.alert-success, .alert-danger {
  background-color: #1a1a1a;
  color: #09c3e4;
  border-color: #09c3e4;
}
</style>