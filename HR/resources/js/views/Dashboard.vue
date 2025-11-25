<template>
  <div class="container py-5" style="background-color: #212626; color: #90c3e4;">
    <!-- Welcome Card -->
    <div class="card shadow-lg mb-5 animate__animated animate__fadeIn" style="background-color: #212626; border: 1px solid #90c3e4;">
      <div class="card-body d-flex justify-content-between align-items-center p-5">
        <div>
          <h2 class="fw-bold text-accent mb-3 animate__animated animate__fadeInUp">{{ mainHeading.title }}</h2>
          <p class="mb-0 text-light animate__animated animate__fadeInUp animate__delay-1s">
            {{ mainHeading.quotation }}
          </p>
        </div>
        <img src="../../../public/images/HR.jpg" alt="welcome" class="img-fluid rounded-circle animate__animated animate__zoomIn" style="width: 8rem; height: 8rem; object-fit: cover; border: 3px solid #90c3e4;">
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4">
      <!-- Total Candidates -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 equal-card animate__animated animate__fadeInLeft" style="background-color: #212626; border: 1px solid #90c3e4;">
          <div class="card-body p-4">
            <h5 class="card-title text-accent text-uppercase mb-3">Total Candidates</h5>
            <h3 class="fw-bold text-accent">{{ totalCandidates }}</h3>
            <p class="text-accent mb-4">40% Change</p>
            <canvas id="totalCandidatesChart" width="250" height="250" style="max-width: 100%;"></canvas>
          </div>
        </div>
      </div>

      <!-- Accepted Candidates -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 equal-card animate__animated animate__fadeInUp" style="background-color: #212626; border: 1px solid #90c3e4;">
          <div class="card-body p-4">
            <h5 class="card-title text-accent text-uppercase mb-3">Accepted Candidates</h5>
            <div class="timeline">
              <div v-for="(candidate, index) in accepted" :key="candidate.name" class="timeline-item">
                <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: rgba(255, 255, 255, 0.1);">
                  <div>
                    <div class="fw-semibold">{{ candidate.name }}</div>
                    <small class="text-accent">{{ candidate.stages }}</small>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <div class="progress-circle" :style="{ '--progress': candidate.percentage / 100 }">
                      <span>{{ candidate.percentage }}%</span>
                    </div>
                  </div>
                </div>
                <div class="timeline-connector" v-if="index < accepted.length - 1"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Upcoming Activities -->
      <div class="col-md-4">
        <div class="card shadow-sm h-100 equal-card animate__animated animate__fadeInRight" style="background-color: #212626; border: 1px solid #90c3e4;">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title text-accent text-uppercase">Upcoming Activities</h5>
              <a href="#" @click.prevent="showPopup = true" class="text-decoration-none text-accent small hover-scale">See All</a>
            </div>
            <div class="timeline">
              <div v-for="(activity, index) in activities" :key="activity.name" class="timeline-item">
                <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: rgba(255, 255, 255, 0.1);">
                  <div>
                    <div class="fw-semibold">{{ activity.candidate_id }} - {{ activity.name }}</div>
                    <small class="text-accent">{{ activity.time }} | <a href="#" class="text-accent text-decoration-none hover-scale">Zoom Link</a></small>
                  </div>
                  <span :class="getStatusClass(activity.status)">{{ activity.status }}</span>
                </div>
                <div class="timeline-connector" v-if="index < activities.length - 1"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Section -->
    <div class="row g-4 mt-4">
      <!-- Report Chart -->
      <div class="col-md-8">
        <div class="card shadow-sm equal-bottom-card animate__animated animate__fadeInLeft" style="background-color: #212626; border: 1px solid #90c3e4;">
          <div class="card-body p-4">
            <h5 class="card-title text-accent text-uppercase mb-3">Total Report of Candidates</h5>
            <canvas id="reportChart" width="700" height="250" style="max-width: 100%;"></canvas>
          </div>
        </div>
      </div>

      <!-- Competence Stages -->
      <div class="col-md-4">
        <div class="card shadow-sm equal-bottom-card animate__animated animate__fadeInRight" style="background-color: #212626; border: 1px solid #90c3e4;">
          <div class="card-body p-4">
            <h5 class="card-title text-accent text-uppercase mb-3">Competence of the Stages</h5>
            <div class="d-grid gap-4">
              <button
                v-for="stage in stages"
                :key="stage.name"
                class="btn btn-outline-accent text-start d-flex justify-content-between align-items-center sleek-hover animate__animated animate__fadeIn"
                style="border-radius: 8px; border-color: #90c3e4; color: #90c3e4; padding: 1rem 1.25rem;"
              >
                {{ stage.name }}
                <i :class="['fas', stage.icon, 'text-accent']"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Popup for Upcoming Activities -->
    <div v-if="showPopup" class="position-fixed top-0 start-0 w-100 h-100 bg-accent bg-opacity-75 d-flex align-items-center justify-content-center animate__animated animate__fadeIn" style="z-index: 1050;">
      <div class="card animate__animated animate__zoomIn" style="width: 90%; max-width: 800px; background-color: #212626; border: 1px solid #90c3e4;">
        <div class="card-header d-flex justify-content-between align-items-center p-4">
          <h5 class="mb-0 text-accent">Upcoming Activities</h5>
          <button @click="showPopup = false" class="close-btn text-accent" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; padding: 0.5rem;">
            &times;
          </button>
        </div>
        <div class="card-body p-4">
          <ul class="list-group list-group-flush">
            <li v-for="activity in activities" :key="activity.name" class="list-group-item bg-transparent text-accent border-0 py-3">
              <strong>ID: {{ activity.candidate_id }}</strong> - {{ activity.name }}<br>
              <small>{{ activity.time }} - Status: <span :class="getStatusClass(activity.status)">{{ activity.status }}</span></small>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from 'axios';

export default {
  data() {
    return {
      showPopup: false,
      totalCandidates: 0,
      newCandidates: 0,
      accepted: [
        { name: 'BILAL AHMED', percentage: 90, stages: '3 Stages attempt' },
        { name: 'Saif Khan', percentage: 80, stages: '3 Stages attempt' },
        { name: 'Aaima Sohail', percentage: 40, stages: '2 Stages attempt' },
        { name: 'Dawood M Shoib', percentage: 70, stages: '2-3 Stages attempt' },
      ],
      activities: [
        { candidate_id: 'C001', name: 'Interview', time: '04:01 PM PKT, Aug 05, 2025', status: 'Pending' },
        { candidate_id: 'C002', name: 'Assessment', time: '10:00 AM PKT, Aug 06, 2025', status: 'Due Soon' },
        { candidate_id: 'C003', name: 'Final Review', time: '02:00 PM PKT, Aug 07, 2025', status: 'Pending' },
      ],
      report: { accepted: 0, rejected: 0, pending: 0 },
      stages: [],
      mainHeading: { title: 'Welcome Back, Human Resourcement', quotation: 'You have 20 new candidates added to your dashboard. Please review and evaluate the latest updates.' },
      totalCandidatesChart: null,
      reportChart: null,
    };
  },
  async mounted() {
    await this.fetchDashboardData();
    this.renderTotalCandidatesChart();
    this.renderReportChart();
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/dashboard-data');
        const data = response.data;
        this.totalCandidates = data.total_candidates || 0;
        this.newCandidates = data.new_candidates || 0;
        this.accepted = data.accepted || [];
        this.activities = data.activities || [];
        this.report = data.report || { accepted: 0, rejected: 0, pending: 0 };
        this.stages = data.stages || [];
        this.mainHeading = data.main_heading || { title: 'Welcome Back, Human Resourcement', quotation: 'You have 20 new candidates added to your dashboard. Please review and evaluate the latest updates.' };

        if (this.totalCandidatesChart) this.totalCandidatesChart.destroy();
        if (this.reportChart) this.reportChart.destroy();
        this.renderTotalCandidatesChart();
        this.renderReportChart();
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
        alert('Failed to load dashboard data. Using default values.');
      }
    },
    getStatusClass(status) {
      switch (status) {
        case 'Completed': return 'badge bg-accent animate__animated animate__pulse animate__infinite';
        case 'Postponed': return 'badge bg-accent animate__animated animate__pulse animate__infinite';
        case 'Scheduled': return 'badge bg-accent animate__animated animate__pulse animate__infinite';
        default: return 'badge bg-accent';
      }
    },
    renderTotalCandidatesChart() {
      const ctx = document.getElementById('totalCandidatesChart').getContext('2d');
      this.totalCandidatesChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Days', 'Week', 'Month', 'Year'],
          datasets: [{
            label: 'Total',
            borderColor: '#00ff00',
            backgroundColor: 'rgba(0, 255, 0, 0.1)',
            data: [0, 0, 0, this.totalCandidates],
            fill: false,
            tension: 0,
            pointRadius: 0,
            borderWidth: 2,
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          aspectRatio: 1,
          plugins: {
            legend: { display: false },
            tooltip: { enabled: false },
          },
          scales: {
            x: {
              ticks: { color: '#00ff00', font: { size: 12 } },
              grid: { color: '#00ff00', lineWidth: 0.5 },
            },
            y: {
              ticks: { color: '#00ff00', font: { size: 12 }, callback: function(value) { return value === 0 ? '00' : value; } },
              grid: { color: '#00ff00', lineWidth: 0.5 },
              min: 0,
              max: 100,
            },
          },
          animation: {
            duration: 0,
          },
        },
      });
    },
    renderReportChart() {
      const ctx = document.getElementById('reportChart').getContext('2d');
      this.reportChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'],
          datasets: [
            {
              label: 'Accepted',
              borderColor: '#90c3e4',
              backgroundColor: 'rgba(144, 195, 228, 0.3)',
              data: [20, 25, 40, 60, 50, 70, 60, this.report.accepted],
              fill: true,
              tension: 0.4,
              pointBackgroundColor: '#90c3e4',
              pointBorderColor: '#212626',
            },
            {
              label: 'Rejected',
              borderColor: '#90c3e4',
              backgroundColor: 'rgba(144, 195, 228, 0.2)',
              data: [10, 15, 30, 40, 60, 50, 40, this.report.rejected],
              fill: true,
              tension: 0.4,
              pointBackgroundColor: '#90c3e4',
              pointBorderColor: '#212626',
            },
            {
              label: 'Pending',
              borderColor: '#90c3e4',
              backgroundColor: 'rgba(144, 195, 228, 0.1)',
              data: [5, 10, 20, 30, 40, 30, 20, this.report.pending],
              fill: true,
              tension: 0.4,
              pointBackgroundColor: '#90c3e4',
              pointBorderColor: '#212626',
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          aspectRatio: 2,
          plugins: {
            legend: { labels: { color: '#90c3e4', font: { size: 14 } } },
            tooltip: { backgroundColor: '#212626', titleColor: '#90c3e4', bodyColor: '#90c3e4' },
          },
          scales: {
            x: { ticks: { color: '#90c3e4', font: { size: 12 } }, grid: { color: 'rgba(144, 195, 228, 0.1)' } },
            y: { ticks: { color: '#90c3e4', font: { size: 12 } }, grid: { color: 'rgba(144, 195, 228, 0.1)' } },
          },
          animation: {
            duration: 2000,
            easing: 'easeInOutQuad',
            onComplete: function () {
              this.options.animation.loop = false;
            },
          },
        },
      });
    },
  },
};
</script>

<style scoped>
.container {
  background-color: #212626;
  border-radius: 12px;
}
.card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(144, 195, 228, 0.2) !important;
}
.card-title {
  font-weight: 700;
  letter-spacing: 0.5px;
}
.text-accent {
  color: #90c3e4;
}
.btn-outline-accent {
  border-color: #90c3e4;
  color: #90c3e4;
}
.btn-outline-accent:hover {
  background-color: rgba(144, 195, 228, 0.1);
}
.equal-card {
  min-height: 400px;
}
.equal-bottom-card {
  min-height: 400px;
}
canvas {
  max-width: 100% !important;
  max-height: 250px !important;
}
.sleek-hover {
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
  border: 1px solid #90c3e4 !important;
}
.sleek-hover::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(144, 195, 228, 0.15), transparent);
  transition: left 0.5s ease;
}
.sleek-hover:hover::after {
  left: 100%;
}
.sleek-hover:hover {
  background-color: rgba(144, 195, 228, 0.05);
  transform: translateY(-2px);
}
.hover-scale {
  transition: transform 0.2s ease;
}
.hover-scale:hover {
  transform: scale(1.05);
}
.badge {
  padding: 0.5em 1em;
  border-radius: 12px;
  font-weight: 600;
  background-color: #212626;
  border: 1px solid #90c3e4;
  color: #90c3e4;
}
.close-btn {
  color: #90c3e4;
  font-size: 1.5rem;
  line-height: 1;
  padding: 0.5rem;
  z-index: 1060;
  transition: transform 0.2s ease, color 0.2s ease;
}
.close-btn:hover {
  color: #ffffff;
  transform: scale(1.2);
}
.close-btn:focus {
  outline: 2px solid #90c3e4;
  outline-offset: 2px;
}
.progress-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: conic-gradient(#90c3e4 var(--progress, 0) * 3.6deg, #212626 0);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.progress-circle::before {
  content: '';
  position: absolute;
  width: 80%;
  height: 80%;
  background-color: #212626;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #90c3e4;
  font-size: 0.8rem;
  font-weight: bold;
}
.progress-circle span {
  position: absolute;
  color: #90c3e4;
  font-size: 0.8rem;
  font-weight: bold;
}
.timeline {
  position: relative;
}
.timeline-item {
  position: relative;
  margin-bottom: 20px;
}
.timeline-connector {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 2px;
  height: 20px;
  background-color: #90c3e4;
  top: 100%;
}
.timeline-connector::before {
  content: '';
  position: absolute;
  top: -10px;
  left: -5px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background-color: #d3a8b1;
}
.timeline-connector::after {
  content: '';
  position: absolute;
  top: 100%;
  left: -3px;
  width: 8px;
  height: 20px;
  background-color: #d3a8b1;
}

/* Importing Animate.css for animations */
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
</style>