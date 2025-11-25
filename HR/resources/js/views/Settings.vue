<template>
  <div class="p-4 bg-dark min-vh-100 text-white">
    <h1 class="mb-5 text-center fw-bold">Settings of the live dashboard</h1>

    <!-- Cards Grid: 2 cards per row -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div v-for="(card, index) in cards" :key="index" class="col d-flex">
        <button
          type="button"
          class="card flex-fill bg-secondary border-0 shadow-sm rounded-4 d-flex align-items-center justify-content-center text-center p-4 fw-semibold fs-5 text-white"
          @click="openModal(index)"
          style="min-height: 180px;"
        >
          {{ card.title }}
        </button>
      </div>
    </div>

    <!-- Bootstrap Modal -->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{ show: selectedCard !== null }"
      :style="selectedCard !== null ? 'display: block;' : ''"
      aria-modal="true"
      role="dialog"
      ref="modal"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header border-bottom border-secondary">
            <h5 class="modal-title">
              {{ selectedCard !== null ? cards[selectedCard].title : '' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row g-3">
                <template v-if="selectedCard !== null">
                  <div
                    v-for="(field, idx) in cards[selectedCard].fields"
                    :key="idx"
                    class="col-12 col-md-6"
                  >
                    <label class="form-label fw-semibold">{{ field.label }}</label>

                    <input
                      v-if="field.type === 'text' && field.label !== 'User ID'"
                      type="text"
                      class="form-control bg-secondary text-white border-secondary"
                      v-model="field.value"
                    />
                    <input
                      v-if="field.type === 'text' && field.label === 'User ID'"
                      type="number"
                      class="form-control bg-secondary text-white border-secondary"
                      v-model.number="field.value"
                      @input="field.value = $event.target.value.replace(/[^0-9]/g, '')"
                    />
                    <input
                      v-else-if="field.type === 'date'"
                      type="date"
                      class="form-control bg-secondary text-white border-secondary"
                      v-model="field.value"
                    />
                    <input
                      v-else-if="field.type === 'time'"
                      type="time"
                      class="form-control bg-secondary text-white border-secondary"
                      v-model="field.value"
                    />
                    <select
                      v-else-if="field.type === 'select'"
                      class="form-select bg-secondary text-white border-secondary"
                      v-model="field.value"
                    >
                      <option
                        v-for="option in field.options"
                        :key="option"
                        :value="option"
                        class="bg-dark text-white"
                      >
                        {{ option }}
                      </option>
                    </select>
                  </div>
                </template>
              </div>
            </form>
          </div>
          <div class="modal-footer border-top border-secondary">
            <button type="button" class="btn btn-primary" @click="updateCard">Update</button>
            <button type="button" class="btn btn-danger" @click="deleteCard">Delete</button>
            <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal backdrop -->
    <div
      v-if="selectedCard !== null"
      class="modal-backdrop fade show"
      @click="closeModal"
    ></div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Settings",
  data() {
    return {
      selectedCard: null,
      cards: [
        {
          title: "OVERALL CANDIDATES OF SQA AND NETWORKING",
          fields: [
            { label: "Total candidate", value: "", type: "text" },
            { label: "User ID", value: "", type: "text" },
            { label: "Field or Job role", value: "", type: "text" },
            { label: "Candidate Name", value: "", type: "text" },
            { label: "Date", value: "", type: "date" },
            { label: "Month", value: "", type: "text" }, // Corrected from 'Auguat' to 'Month'
            { label: "Year", value: "", type: "text" },
          ],
        },
        {
          title: "TOP NOTCH ACCEPTED CANDIDATES",
          fields: [
            { label: "User ID", value: "", type: "text" },
            { label: "Field or Job role", value: "", type: "text" },
            { label: "Candidate Name", value: "", type: "text" },
            { label: "Total Stages Attempt", value: "", type: "text" },
            { label: "Aggregate of Stages", value: "", type: "text" },
          ],
        },
        {
          title: "TOTAL ACCEPTED AND REJECTED CANDIDATES",
          fields: [
            { label: "Total candidate", value: "", type: "text" },
            { label: "User ID", value: "", type: "text" },
            { label: "Field or Job role", value: "", type: "text" },
            { label: "Candidate Name", value: "", type: "text" },
            {
              label: "Progress",
              value: "",
              type: "select",
              options: ["Accepted", "Rejected"],
            },
            { label: "Year", value: "", type: "text" },
          ],
        },
        {
          title: "CHECK UPCOMING ACTIVITIES OF CANDIDATES",
          fields: [
            { label: "Total candidate", value: "", type: "text" },
            { label: "User ID", value: "", type: "text" },
            { label: "Field or Job role", value: "", type: "text" },
            { label: "Meeting with Candidate Name", value: "", type: "text" },
            { label: "Time", value: "", type: "time" },
            {
              label: "Online meeting/Offline Meeting",
              value: "",
              type: "select",
              options: ["Online", "Offline"],
            },
            {
              label: "Condition of Meeting",
              value: "",
              type: "select",
              options: ["Scheduled", "Postponed", "Completed"],
            },
          ],
        },
        {
          title: "DEFAULT CHANGES ON MAIN HEADING",
          fields: [
            { label: "Title", value: "", type: "text" },
            { label: "Quotation", value: "", type: "text" },
          ],
        },
      ],
    };
  },
  methods: {
    openModal(index) {
      this.selectedCard = index;
      document.body.classList.add("modal-open");
    },
    closeModal() {
      this.selectedCard = null;
      document.body.classList.remove("modal-open");
    },
    async updateCard() {
      const card = this.cards[this.selectedCard];

      // Check for empty fields
      const invalidFields = card.fields.filter(field => !field.value || field.value.trim() === '');
      if (invalidFields.length > 0) {
        alert('Please fill in all fields: ' + invalidFields.map(f => f.label).join(', '));
        return;
      }

      // Validate specific field formats
      if (card.title === 'OVERALL CANDIDATES OF SQA AND NETWORKING') {
        const dateField = card.fields.find(f => f.label === 'Date');
        if (dateField && !/^\d{4}-\d{2}-\d{2}$/.test(dateField.value)) {
          alert('Date must be in YYYY-MM-DD format (e.g., 2025-08-05)');
          return;
        }
        const yearField = card.fields.find(f => f.label === 'Year');
        if (yearField && !/^\d{4}$/.test(yearField.value)) {
          alert('Year must be a valid 4-digit year (e.g., 2025)');
          return;
        }
        const userIdField = card.fields.find(f => f.label === 'User ID');
        if (userIdField && !/^\d+$/.test(userIdField.value)) {
          alert('User ID must be a valid number');
          return;
        }
        const monthField = card.fields.find(f => f.label === 'Month');
        if (monthField && !/^(January|February|March|April|May|June|July|August|September|October|November|December)$/.test(monthField.value)) {
          alert('Month must be a valid month name (e.g., August)');
          return;
        }
      }

      if (card.title === 'CHECK UPCOMING ACTIVITIES OF CANDIDATES') {
        const timeField = card.fields.find(f => f.label === 'Time');
        if (timeField && !/^\d{2}:\d{2}(:\d{2})?$/.test(timeField.value)) {
          alert('Time must be in HH:MM or HH:MM:SS format (e.g., 14:30)');
          return;
        }
        const meetingTypeField = card.fields.find(f => f.label === 'Online meeting/Offline Meeting');
        if (meetingTypeField && !['Online', 'Offline'].includes(meetingTypeField.value)) {
          alert('Please select either "Online" or "Offline" for meeting type');
          return;
        }
        const conditionField = card.fields.find(f => f.label === 'Condition of Meeting');
        if (conditionField && !['Scheduled', 'Postponed', 'Completed'].includes(conditionField.value)) {
          alert('Please select a valid condition for the meeting');
          return;
        }
      }

      if (card.title === 'TOTAL ACCEPTED AND REJECTED CANDIDATES') {
        const progressField = card.fields.find(f => f.label === 'Progress');
        if (progressField && !['Accepted', 'Rejected'].includes(progressField.value)) {
          alert('Please select either "Accepted" or "Rejected" for progress');
          return;
        }
        const yearField = card.fields.find(f => f.label === 'Year');
        if (yearField && !/^\d{4}$/.test(yearField.value)) {
          alert('Year must be a valid 4-digit year (e.g., 2025)');
          return;
        }
        const userIdField = card.fields.find(f => f.label === 'User ID');
        if (userIdField && !/^\d+$/.test(userIdField.value)) {
          alert('User ID must be a valid number');
          return;
        }
      }

      try {
        const response = await axios.post('/api/dashboard-settings', {
          card_type: card.title,
          fields: card.fields,
        });
        alert(`Updated: ${card.title}\n${response.data.message}`);
        this.closeModal();
      } catch (error) {
        console.error('Error saving data:', error);
        if (error.response && error.response.data) {
          console.log('Server Response:', error.response.data);
          alert('Failed to save data: ' + JSON.stringify(error.response.data, null, 2));
        } else {
          alert('Failed to save data: Unknown server error');
        }
      }
    },
    deleteCard() {
      const title = this.cards[this.selectedCard].title;
      if (confirm(`Are you sure you want to delete "${title}"?`)) {
        this.cards.splice(this.selectedCard, 1);
        this.selectedCard = null;
        document.body.classList.remove("modal-open");
      }
    },
  },
};
</script>

<style scoped>
.bg-dark {
  background-color: rgb(33, 38, 38) !important;
}

.modal-open {
  overflow: hidden;
}

/* Override default modal fade for Vue toggling */
.modal.fade {
  transition: none !important;
}

.modal.show {
  display: block !important;
}

/* Card button hover */
.card:hover {
  background-color: #343a40 !important;
  cursor: pointer;
  transform: scale(1.03);
  transition: transform 0.3s ease, background-color 0.3s ease;
}
</style>