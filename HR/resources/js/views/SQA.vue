<template>
  <div class="container py-5 text-white min-vh-100" style="background-color: #212626;">
    <!-- Header with Filter -->
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div>
        <h2 class="fw-bold mb-1 text-accent">
          <i class="fas fa-chart-line me-2"></i> SQA CANDIDATES
        </h2>
        <p class="text-muted mb-0">Track, update, and manage candidate data easily.</p>
      </div>
      <div class="d-flex gap-2 w-100 w-md-50">
        <div class="input-group shadow-sm flex-grow-1">
          <input
            type="text"
            class="form-control rounded-start border-accent"
            v-model="filterQuery"
            placeholder="Filter by Gmail or Username"
          />
          <button class="btn btn-accent text-white rounded-end" @click="applyFilter">
            <i class="fas fa-filter me-1"></i> Filter
          </button>
        </div>
        <button class="btn btn-accent shadow" @click="openForm()">
          <i class="fas fa-plus me-2"></i> Add Candidate
        </button>
      </div>
    </div>

    <!-- Candidates Table -->
    <div class="card bg-secondary shadow-sm text-white">
      <div class="card-body table-responsive">
        <table class="table table-dark table-hover table-bordered align-middle text-center mb-0">
          <thead class="bg-accent text-dark">
            <tr>
              <th>Unique ID</th>
              <th>Candidate Name</th>
              <th>Gmail</th>
              <th>Field</th>
              <th>Job Role</th>
              <th>Qualification</th>
              <th>Age</th>
              <th>Location</th>
              <th>CNIC</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(candidate, index) in filteredCandidates" :key="candidate.id">
              <td>{{ candidate.user_id }}</td>
              <td>{{ candidate.name }}</td>
              <td>{{ candidate.email }}</td>
              <td>{{ candidate.field }}</td>
              <td>{{ candidate.jobrole }}</td>
              <td>{{ candidate.qualification }}</td>
              <td>{{ candidate.age }}</td>
              <td>{{ candidate.location }}</td>
              <td>{{ candidate.cnic }}</td>
              <td>
                <button class="btn btn-sm btn-outline-accent me-2" @click="openForm(candidate, index)">Edit</button>
                <button class="btn btn-sm btn-outline-danger" @click="deleteCandidate(index)">Delete</button>
              </td>
            </tr>
            <tr v-if="filteredCandidates.length === 0">
              <td colspan="10" class="text-muted">No data available.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" :class="{ show: showModal }" style="display: block" v-if="showModal">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background-color: #212626;">
          <div class="modal-header border-0">
            <h5 class="modal-title text-accent">
              {{ editIndex !== null ? 'Edit Candidate' : 'Add Candidate' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" @click="closeForm()"></button>
          </div>

          <div class="modal-body">
            <form class="row g-4">
              <div class="col-md-6">
                <label class="form-label">User ID</label>
                <input
                  v-model.number="form.user_id"
                  type="number"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="User ID"
                  required
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Gmail</label>
                <input
                  v-model="form.email"
                  type="email"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Gmail"
                  required
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Username</label>
                <input
                  v-model="form.name"
                  type="text"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Username"
                  required
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Field</label>
                <input
                  v-model="form.field"
                  type="text"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Field"
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Job Role</label>
                <input
                  v-model="form.jobrole"
                  type="text"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Job Role"
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Qualification</label>
                <input
                  v-model="form.qualification"
                  type="text"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Qualification"
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Age</label>
                <input
                  v-model.number="form.age"
                  type="number"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Age"
                  required
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">Location</label>
                <input
                  v-model="form.location"
                  type="text"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="Location"
                />
              </div>
              <div class="col-md-6">
                <label class="form-label">CNIC</label>
                <input
                  v-model="form.cnic"
                  type="text"
                  class="form-control bg-secondary text-white uniform-field"
                  placeholder="CNIC"
                />
              </div>
            </form>
          </div>

          <div class="modal-footer border-0">
            <button class="btn btn-secondary" @click="closeForm">Cancel</button>
            <button class="btn btn-accent" @click="saveCandidate">
              {{ editIndex !== null ? 'Update' : 'Create' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Candidates',
  data() {
    return {
      filterQuery: '',
      candidates: [],
      filteredCandidates: [],
      showModal: false,
      editIndex: null,
      form: {
        id: null,
        user_id: '',
        email: '',
        name: '',
        field: '',
        jobrole: '',
        qualification: '',
        age: '',
        location: '',
        cnic: '',
      },
    };
  },
  mounted() {
    this.fetchCandidates();
  },
  methods: {
    async fetchCandidates() {
      try {
        const response = await fetch('/candidate-sqa');
        const data = await response.json();
        this.candidates = data;
        this.filteredCandidates = this.candidates;
      } catch (error) {
        console.error('Error fetching candidates:', error);
      }
    },
    applyFilter() {
      const query = this.filterQuery.trim().toLowerCase();
      if (!query) {
        this.filteredCandidates = this.candidates;
      } else {
        this.filteredCandidates = this.candidates.filter(
          (c) =>
            c.email?.toLowerCase().includes(query) ||
            c.name?.toLowerCase().includes(query)
        );
      }
    },
    openForm(candidate = null, index = null) {
      this.editIndex = index;
      this.form = candidate
        ? { ...candidate }
        : {
            id: null,
            user_id: '',
            email: '',
            name: '',
            field: '',
            jobrole: '',
            qualification: '',
            age: '',
            location: '',
            cnic: '',
          };
      this.showModal = true;
    },
    closeForm() {
      this.showModal = false;
    },
    async saveCandidate() {
      try {
        const payload = { ...this.form };
        let method = this.editIndex !== null ? 'PUT' : 'POST';
        let url =
          method === 'PUT'
            ? `/candidate-sqa/${payload.id}`
            : '/candidate-sqa';

        const response = await fetch(url, {
          method,
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(payload),
        });

        if (!response.ok) throw new Error('Failed to save');

        await this.fetchCandidates();
        this.closeForm();
      } catch (err) {
        console.error('Save error:', err);
      }
    },
    async deleteCandidate(index) {
      const candidate = this.filteredCandidates[index];
      if (!candidate || !candidate.id) return;

      if (confirm('Are you sure you want to delete this candidate?')) {
        try {
          await fetch(`/candidate-sqa/${candidate.id}`, {
            method: 'DELETE',
          });
          await this.fetchCandidates();
        } catch (err) {
          console.error('Delete error:', err);
        }
      }
    },
  },
};
</script>

<style scoped>
.modal {
  background-color: rgba(33, 38, 38, 0.75);
}
.modal.show .modal-dialog {
  transform: translateY(0);
  transition: transform 0.3s ease-out;
}
.uniform-field {
  height: 42px;
  min-width: 100%;
  box-sizing: border-box;
}
.text-accent {
  color: #90c3e4;
}
.btn-accent {
  background-color: #90c3e4;
  border-color: #90c3e4;
  color: #212626;
}
.btn-accent:hover {
  background-color: rgba(144, 195, 228, 0.8);
  border-color: #90c3e4;
}
.btn-outline-accent {
  border-color: #90c3e4;
  color: #90c3e4;
}
.btn-outline-accent:hover {
  background-color: rgba(144, 195, 228, 0.1);
}
</style>