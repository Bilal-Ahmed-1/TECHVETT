<template>
  <div class="container py-5 text-white min-vh-100" style="background-color: #212626">
    <!-- Header with Job Role Filter -->
    <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
      <div>
        <h2 class="fw-bold mb-1 text-accent">
          <i class="fas fa-tasks me-2"></i> ASSESSMENT DASHBOARD
        </h2>
        <p class="text-muted mb-0">Track, update, and manage user assessment data easily.</p>
      </div>
      <div class="d-flex align-items-center gap-2">
        <select v-model="selectedJobRole" class="form-select bg-secondary text-white border-accent">
          <option value="">All Job Roles</option>
          <option v-for="role in uniqueJobRoles" :key="role" :value="role">{{ role }}</option>
        </select>
        <button class="btn btn-accent shadow" @click="openForm()">
          <i class="fas fa-plus me-2"></i> Add Assessment
        </button>
      </div>
    </div>

    <!-- Assessment Table -->
    <div class="card bg-secondary shadow-sm text-white">
      <div class="card-body table-responsive">
        <table class="table table-dark table-hover table-bordered align-middle text-center mb-0">
          <thead class="bg-accent text-dark">
            <tr>
              <th>Candidate ID</th>
              <th>Name</th>
              <th>Field</th>
              <th>Job Role</th>
              <th>Experience</th>
              <th>Stage 1</th>
              <th>Stage 2</th>
              <th>Stage 3</th>
              <th>Status</th>
              <th>Result</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in filteredUsers" :key="user.user_id">
              <td>{{ user.user_id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.field }}</td>
              <td>{{ user.job_role }}</td>
              <td>{{ user.experience }}</td>
              <td>{{ user.stage1 }}</td>
              <td>{{ user.stage2 }}</td>
              <td>{{ user.stage3 }}</td>
              <td>{{ user.status }}</td>
              <td>{{ user.result }}</td>
              <td>
                <button class="btn btn-sm btn-outline-accent" @click="openForm(user, index)">Edit</button>
              </td>
            </tr>
            <tr v-if="filteredUsers.length === 0">
              <td colspan="11" class="text-muted">No data available.</td>
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
              {{ editIndex !== null ? 'Edit Assessment' : 'Add Assessment' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" @click="closeForm()"></button>
          </div>

          <div class="modal-body">
            <form class="row g-4">
              <div class="col-md-6"><label class="form-label">User ID</label>
                <input v-model="form.user_id" type="text" class="form-control bg-secondary text-white uniform-field" placeholder="User ID" required/>
              </div>
              <div class="col-md-6"><label class="form-label">Name</label>
                <input v-model="form.name" type="text" class="form-control bg-secondary text-white uniform-field" placeholder="Name" required/>
              </div>
              <div class="col-md-6"><label class="form-label">Field</label>
                <input v-model="form.field" type="text" class="form-control bg-secondary text-white uniform-field" placeholder="Field"/>
              </div>
              <div class="col-md-6"><label class="form-label">Job Role</label>
                <input v-model="form.job_role" type="text" class="form-control bg-secondary text-white uniform-field" placeholder="Job Role"/>
              </div>
              <div class="col-md-6"><label class="form-label">Experience</label>
                <input v-model="form.experience" type="text" class="form-control bg-secondary text-white uniform-field" placeholder="Experience"/>
              </div>

              <div class="col-md-4" v-for="n in 3" :key="n">
                <label class="form-label">Stage {{ n }}</label>
                <select v-model="form[`stage${n}`]" class="form-select bg-secondary text-white uniform-field">
                  <option disabled :value="''">Select</option>
                  <option v-for="i in 15" :key="i" :value="i">{{ i }}</option>
                </select>
              </div>

              <div class="col-md-6"><label>Status</label>
                <select v-model="form.status" class="form-select bg-secondary text-white uniform-field">
                  <option disabled value="">Select Status</option>
                  <option>Accept</option>
                  <option>Reject</option>
                  <option>Pending</option>
                </select>
              </div>

              <div class="col-md-6"><label>Result</label>
                <select v-model="form.result" class="form-select bg-secondary text-white uniform-field">
                  <option disabled value="">Select Result</option>
                  <option>Successful</option>
                  <option>Unsuccessful</option>
                </select>
              </div>
            </form>
          </div>

          <div class="modal-footer border-0">
            <button class="btn btn-secondary" @click="closeForm">Cancel</button>
            <button class="btn btn-accent" @click="saveUser">{{ editIndex !== null ? 'Update' : 'Create' }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Assessment',
  data() {
    return {
      selectedJobRole: '',
      users: [],
      showModal: false,
      editIndex: null,
      form: {
        user_id: '',
        name: '',
        field: '',
        job_role: '',
        experience: '',
        stage1: '',
        stage2: '',
        stage3: '',
        status: '',
        result: '',
      },
    };
  },
  computed: {
    uniqueJobRoles() {
      const roles = this.users.map(u => u.job_role);
      return [...new Set(roles)];
    },
    filteredUsers() {
      return this.selectedJobRole
        ? this.users.filter(u => u.job_role === this.selectedJobRole)
        : this.users;
    },
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
          }));
        })
        .catch(async err => {
          console.error("Fetch error:", err);
          const text = await fetch('/test-scores').then(r => r.text());
          console.warn("Raw response:", text);
        });
    },
    openForm(user = null, index = null) {
      this.editIndex = index;
      this.form = user ? { ...user } : {
        user_id: '', name: '', field: '', job_role: '',
        experience: '', stage1: '', stage2: '', stage3: '',
        status: '', result: '',
      };
      this.showModal = true;
    },
    closeForm() {
      this.showModal = false;
    },
    saveUser() {
      if (this.editIndex !== null) {
        this.users.splice(this.editIndex, 1, { ...this.form });
      } else {
        this.users.push({ ...this.form });
      }
      this.closeForm();
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
.bg-accent {
  background-color: #90c3e4;
}
.border-accent {
  border-color: #90c3e4;
}
</style>