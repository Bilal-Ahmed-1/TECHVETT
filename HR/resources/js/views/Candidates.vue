<template>
  <div class="container my-5">
    <!-- Header -->
    <h1 class="display-4 text-white mb-5 text-center fw-bold">CANDIDATE SELECTION</h1>

    <!-- Main Content: Equal Width and Height Cards -->
    <div class="row g-4">
      <!-- Filter Panel Card (6 columns) -->
      <div class="col-md-6 d-flex">
        <div class="card shadow-sm bg-light rounded-3 flex-fill">
          <div class="card-body d-flex flex-column" style="min-height: 26rem;">
            <div class="mb-4 flex-grow-1">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search Candidates"
                class="form-control form-control-lg mb-3"
              />
              <input
                v-model="uploadId"
                type="text"
                placeholder="Upload ID"
                class="form-control form-control-lg mb-3"
              />
              <input
                v-model="jobRole"
                type="text"
                placeholder="Field or Job role"
                class="form-control form-control-lg mb-3"
              />
              <button
                @click="filterCandidates"
                class="btn btn-primary w-100 mb-3"
              >
                Filter
              </button>
              <div v-if="filteredUsers.length > 0" class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Job Role</th>
                      <th>Stage 1</th>
                      <th>Stage 2</th>
                      <th>Stage 3</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in filteredUsers" :key="user.user_id">
                      <td>{{ user.user_id }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.job_role }}</td>
                      <td>{{ user.stage1 || 'N/A' }}</td>
                      <td>{{ user.stage2 || 'N/A' }}</td>
                      <td>{{ user.stage3 || 'N/A' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div v-else-if="showFilterResults" class="text-center text-muted">
                No candidates found.
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Resume Preview Card (6 columns) -->
      <div class="col-md-6 d-flex">
        <div class="card shadow-sm bg-light rounded-3 flex-fill">
          <div
            class="card-body d-flex flex-column justify-content-center align-items-center"
            style="min-height: 26rem; height: 100vh; overflow: auto;"
          >
            <div v-if="!selectedFile && !pdfUrl" class="text-center w-100 h-100">
              <i class="bi bi-file-earmark-text display-1 text-muted mb-3"></i>
              <p class="text-muted fs-5 mb-4">Resume preview placeholder</p>
              <label
                class="btn btn-outline-primary btn-lg px-4 fw-semibold"
                style="cursor: pointer;"
              >
                <i class="bi bi-upload me-2"></i> Upload Resume
                <input
                  type="file"
                  class="d-none"
                  @change="handleFileUpload"
                  accept=".pdf"
                />
              </label>
            </div>
            <div v-else class="w-100 h-100">
              <iframe
                :src="pdfUrl"
                class="w-100 h-100"
                style="border: none; height: 100vh;"
                type="application/pdf"
                @load="onPdfLoad"
                @error="onPdfError"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-center gap-4 mt-5 flex-wrap">
      <button @click="handleAction('Accept')" class="btn btn-success btn-lg px-4 fw-semibold">
        <i class="bi bi-check-circle me-2"></i> Accept
      </button>
      <button @click="handleAction('Pending')" class="btn btn-warning btn-lg px-4 fw-semibold">
        <i class="bi bi-hourglass-split me-2"></i> Pending
      </button>
      <button @click="handleAction('Reject')" class="btn btn-danger btn-lg px-4 fw-semibold">
        <i class="bi bi-x-circle me-2"></i> Reject
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      users: [],
      searchQuery: '',
      uploadId: '',
      jobRole: '',
      stages: ['Stage 1', 'Stage 2', 'Stage 3'],
      selectedStage: 'Stage 1',
      selectedFile: null,
      pdfUrl: '',
      filteredUsers: [],
      showFilterResults: false,
    };
  },
  mounted() {
    this.fetchTestScores();
  },
  methods: {
    fetchTestScores() {
      fetch('/test-scores')
        .then(res => {
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          return res.json();
        })
        .then(data => {
          if (!Array.isArray(data)) throw new Error("Data is not an array");
          this.users = data.map(u => ({
            user_id: u.user_id,
            name: u.name,
            field: u.field,
            job_role: u.jobrole,
            experience: u.experience,
            stage1: u.stage1,
            stage2: u.stage2,
            stage3: u.stage3,
            status: u.status || 'Pending',
            result: u.result || 'N/A',
            resume_url: u.resume_url || '', // Assuming resume_url is available
          }));
        })
        .catch(async err => {
          console.error("Fetch error:", err);
          const text = await fetch('/test-scores').then(r => r.text());
          console.warn("Raw response:", text);
        });
    },
    filterCandidates() {
      this.filteredUsers = this.users.filter(user => {
        const nameMatch = user.name.toLowerCase().includes(this.searchQuery.toLowerCase());
        const idMatch = user.user_id.toString().includes(this.uploadId);
        const roleMatch = user.job_role.toLowerCase().includes(this.jobRole.toLowerCase());
        return nameMatch && idMatch && roleMatch;
      });
      this.showFilterResults = true;
      this.pdfUrl = ''; // Clear preview on filter
    },
    handleFileUpload(event) {
      this.selectedFile = event.target.files[0];
      if (this.selectedFile) {
        this.pdfUrl = URL.createObjectURL(this.selectedFile);

        const formData = new FormData();
        formData.append('resume', this.selectedFile);
        formData.append('upload_id', this.uploadId || '');
        formData.append('job_role', this.jobRole || '');

        axios
          .post('/api/upload-resume', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then((response) => {
            console.log('Upload successful:', response.data);
            alert('Resume uploaded successfully!');
            this.selectedFile = null; // Clear file after upload
          })
          .catch((error) => {
            console.error('Upload failed:', error.response ? error.response.data : error.message);
            alert('Failed to upload resume. Check console for details. (404: Endpoint not found)');
          });
      }
    },
    onPdfLoad() {
      console.log('PDF loaded successfully');
    },
    onPdfError() {
      console.error('Failed to load PDF');
      this.pdfUrl = '';
      alert('Error loading PDF. Please upload a valid PDF file or check the URL.');
    },
    handleAction(action) {
      const email = 'bilalahmed082000@gmail.com'; // Fixed email for now
      const name = 'Bilal Ahmed'; // Fixed name for now

      axios
        .post('/api/candidate-action', {
          action: action,
          email: email,
          name: name,
        })
        .then((response) => {
          alert(`"${action}" email sent to ${email}.`);
        })
        .catch((error) => {
          console.error(error.response ? error.response.data : error.message);
          alert(`Failed to send "${action}" email. Check console for details.`);
        });
    },
  },
};
</script>

<style scoped>
body {
  background-color: #212529;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

h1 {
  letter-spacing: 1.5px;
}

.card {
  border: none;
}

input::placeholder {
  color: #6c757d !important;
}

.btn-primary,
.btn-outline-primary {
  transition: background-color 0.3s ease, border-color 0.3s ease;
}

.btn-primary:hover,
.btn-outline-primary:hover {
  background-color: #0d6efd !important;
  border-color: #0d6efd !important;
}

.table {
  color: #90c3e4 !important;
  background-color: #212626 !important;
}

.table th,
.table td {
  vertical-align: middle !important;
  border-color: #90c3e4 !important;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: #212626 !important;
}

.table-striped tbody tr:nth-of-type(even) {
  background-color: #2a2f32 !important; /* Slightly lighter shade for contrast */
}

@media (max-width: 767.98px) {
  .btn {
    width: 100%;
    margin-bottom: 0.5rem;
  }
}
</style>