<template>
  <div id="app" class="d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="text-white" :class="{ 'collapsed': isSidebarCollapsed }">
      <div class="d-flex align-items-center p-3">
        <button class="toggle-btn" type="button" @click="toggleSidebar">
          <img src="/public/images/logo.png" alt="TECHVETT Logo" />
        </button>
        <div class="sidebar-logo ms-3">
          <a href="#" class="text-decoration-none fs-2 fw-bold title">TECHVETT</a>
        </div>
      </div>
      <nav class="nav flex-column sidebar-nav list-unstyled px-3">
        <div v-for="item in menu" :key="item.label" class="sidebar-item">
          <div v-if="item.label === 'CATEGORIES'">
            <a
              href="#"
              class="sidebar-link collapsed has-dropdown d-flex align-items-center text-decoration-none"
              :data-bs-target="'#categories'"
              data-bs-toggle="collapse"
              :aria-expanded="isDropdownOpen(item.label)"
              aria-controls="categories"
              @click="toggleDropdown(item.label)"
            >
              <i :class="['fas', item.icon, 'me-4', 'fs-4', 'icon-bounce']"></i>
              <span class="">{{ item.label }}</span>
              <i :class="['fas', isDropdownOpen(item.label) ? 'fa-chevron-down' : 'fa-chevron-right', 'ms-auto']"></i>
            </a>
            <ul
              id="categories"
              class="sidebar-dropdown list-unstyled collapse ps-4"
              data-bs-parent="#sidebar"
            >
              <li v-for="subItem in item.subItems" :key="subItem.label">
                <router-link
                  :to="subItem.route"
                  class="sidebar-link d-flex align-items-center text-decoration-none"
                >
                  <i :class="['fas', subItem.icon, 'me-4', 'fs-4', 'icon-bounce']"></i>
                  <span class="">{{ subItem.label }}</span>
                </router-link>
              </li>
            </ul>
          </div>
          <router-link
            v-else-if="item.label !== 'Sign Out'"
            :to="item.route"
            class="sidebar-link d-flex align-items-center text-decoration-none"
          >
            <i :class="['fas', item.icon, 'me-4', 'fs-4', 'icon-bounce']"></i>
            <span class="">{{ item.label }}</span>
          </router-link>
        </div>
        <div class="sidebar-footer" v-if="menu.find(item => item.label === 'Sign Out')">
          <a
            href="#"
            class="sidebar-link d-flex align-items-center text-decoration-none"
            @click.prevent="logout"
          >
            <i :class="['fas', 'fa-sign-out-alt', 'me-4', 'fs-4', 'icon-bounce']"></i>
            <span class="">Logout</span>
          </a>
          <form id="logout-form" action="/logout" method="POST" class="d-none">
            <input type="hidden" name="_token" :value="csrfToken">
          </form>
        </div>
      </nav>
    </aside>

    <!-- Right Section -->
    <div class="flex-grow-1 d-flex flex-column" :style="{ 'margin-left': isSidebarCollapsed ? '80px' : '16rem' }">
      <!-- Topbar -->
      <header
        class="p-3 d-flex justify-content-end align-items-center"
        style="height: 56px; position: fixed; top: 0; right: 0; left: 16rem; z-index: 999; background-color: #212626;"
      >
        <div class="d-flex align-items-center">
          <div class="me-4 fs-4 position-relative">
            <input
              type="text"
              class="form-control"
              placeholder="Search Dashboard, Categories, etc."
              style="width: 350px;"
              v-model="searchQuery"
              @input="searchQuery = $event.target.value"
            />
            <div
              v-if="searchQuery && filteredMenuItems.length"
              class="position-absolute bg-white text-dark p-3 shadow notification-popup comic-popup"
              style="top: 40px; left: 0; width: 350px;"
            >
              <h6 class="fw-bold mb-2">Search Results</h6>
              <ul class="list-unstyled mb-0">
                <li v-for="item in filteredMenuItems" :key="item.label" class="py-1">
                  <router-link
                    :to="item.route"
                    class="text-decoration-none text-dark d-flex align-items-center"
                    @click="clearSearch"
                  >
                    <i :class="['fas', item.icon, 'me-2', 'fs-5']"></i>
                    <span>{{ item.label }}</span>
                  </router-link>
                </li>
              </ul>
            </div>
          </div>
          <div class="position-relative me-4 fs-4 icon-wrapper">
            <i class="fas fa-bell icon-bounce" style="color: #90c3e4;" @click="toggleNotification"></i>
            <span v-if="notifications.length" class="notification-badge">{{ notifications.length }}</span>
            <div
              v-if="showNotification"
              class="position-absolute text-dark p-3 shadow notification-popup comic-popup"
              style="top: 40px; right: 0; width: 300px;"
            >
              <h6 class="fw-bold mb-2 comic-title">Notifications</h6>
              <ul class="list-unstyled mb-0">
                <li v-for="notification in notifications" :key="notification.id" class="py-1 comic-text">
                  • {{ notification.message }}
                </li>
              </ul>
            </div>
          </div>
          <div class="position-relative me-4 fs-4 icon-wrapper">
            <i class="fas fa-bullhorn icon-bounce" style="color: #90c3e4;" @click="toggleAnnouncement"></i>
            <span v-if="announcements.length" class="notification-badge">{{ announcements.length }}</span>
            <div
              v-if="showAnnouncement"
              class="position-absolute text-dark p-3 shadow notification-popup comic-popup"
              style="top: 40px; right: 0; width: 300px;"
            >
              <h6 class="fw-bold mb-2 comic-title">Announcements</h6>
              <ul class="list-unstyled mb-0">
                <li v-for="announcement in announcements" :key="announcement.id" class="py-1 comic-text">
                  • {{ announcement.message }}
                </li>
              </ul>
            </div>
          </div>
          <img
            src="https://i.pravatar.cc/40"
            alt="avatar"
            class="rounded-circle border border-secondary bg-black"
            style="width: 2.5rem; height: 2.5rem;"
          />
        </div>
      </header>

      <!-- Scrollable Main Content -->
      <main
        class="p-4"
        style="background-color: #212626; margin-top: 56px; height: calc(100vh - 56px); overflow-y: auto;"
      >
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      menu: [
        { icon: 'fa-home', label: 'DASHBOARD', route: '/' },
        {
          icon: 'fa-layer-group',
          label: 'CATEGORIES',
          subItems: [
            { label: 'SQA', route: '/categories/sqa', icon: 'fa-chart-line' },
            { label: 'Networking', route: '/categories/networking', icon: 'fa-network-wired' },
          ],
        },
        { icon: 'fa-clipboard-check', label: 'ASSESSEMENT', route: '/assessment' },
        { icon: 'fa-users', label: 'CANDIDATES', route: '/candidates' },
        { icon: 'fa-cogs', label: 'SETTINGS', route: '/settings' },
        { icon: 'fa-sign-out-alt', label: 'Sign Out' },
      ],
      notifications: [
        { id: 1, message: 'New candidate has arrived: John Doe' },
        { id: 2, message: 'Test will be starting soon: SQA Assessment' },
        { id: 3, message: 'Candidate profile updated' },
      ],
      announcements: [
        { id: 1, message: 'New test schedule released for next week' },
        { id: 2, message: 'System maintenance planned this weekend' },
      ],
      openDropdown: null,
      isSidebarCollapsed: false,
      csrfToken: document.querySelector('meta[name="csrf-token"]')?.content,
      showNotification: false,
      showAnnouncement: false,
      searchQuery: '',
    };
  },
  computed: {
    filteredMenuItems() {
      const query = this.searchQuery.toLowerCase().trim();
      if (!query) return [];
      const items = [];
      this.menu.forEach(item => {
        if (item.label !== 'Sign Out') {
          if (item.subItems) {
            item.subItems.forEach(subItem => {
              if (subItem.label.toLowerCase().includes(query)) {
                items.push({ ...subItem, icon: subItem.icon });
              }
            });
          } else if (item.label.toLowerCase().includes(query)) {
            items.push({ ...item });
          }
        }
      });
      return items;
    },
  },
  methods: {
    toggleDropdown(label) {
      this.openDropdown = this.openDropdown === label ? null : label;
    },
    isDropdownOpen(label) {
      return this.openDropdown === label;
    },
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed;
    },
    logout() {
      document.getElementById('logout-form').submit();
    },
    toggleNotification() {
      this.showNotification = !this.showNotification;
      this.showAnnouncement = false;
      this.searchQuery = '';
    },
    toggleAnnouncement() {
      this.showAnnouncement = !this.showAnnouncement;
      this.showNotification = false;
      this.searchQuery = '';
    },
    clearSearch() {
      this.searchQuery = '';
    },
  },
};
</script>

<style scoped>
#sidebar {
  font-family: 'Roboto Mono', monospace;
  width: 16rem;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 1000;
  background-color: #212626 !important;
  transition: width 0.3s ease;
}

#sidebar.collapsed {
  width: 100px;
}

#sidebar.collapsed .sidebar-logo,
#sidebar.collapsed .sidebar-nav span,
#sidebar.collapsed .sidebar-footer span {
  display: none;
}

.sidebar-link {
  padding: 1.5rem 0.75rem;
  color: #90c3e4;
  text-decoration: none !important;
  font-size: 1.4rem !important;
  display: flex;
  align-items: center;
  border-radius: 4px;
  margin-bottom: 0.25rem;
}

.sidebar-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.sidebar-footer {
  position: absolute;
  bottom: 0;
  margin-bottom: 5px;
  width: 88%;
}

.toggle-btn {
  background: none;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  height: 50px;
}

.toggle-btn img {
  width: 40px;
  height: 40px;
}

.sidebar-logo a {
  font-size: 1.25rem;
  font-weight: 600;
  color: #90c3e4;
  text-decoration: none !important;
}

.sidebar-item i {
  font-size: 1.1rem;
}

/* Bouncing animation for sidebar icons */
.icon-bounce:hover {
  animation: bounce 0.3s ease infinite;
}

@keyframes bounce {
  0%, 100% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
}

/* Icon wrapper for notifications and announcements */
.icon-wrapper {
  position: relative;
  cursor: pointer;
}

.icon-wrapper .fa-bell,
.icon-wrapper .fa-bullhorn {
  transition: all 0.3s ease;
}

.icon-wrapper:hover .fa-bell,
.icon-wrapper:hover .fa-bullhorn {
  animation: bounceAndGlow 0.6s ease-in-out;
}

@keyframes bounceAndGlow {
  0% {
    transform: scale(1);
    filter: brightness(100%);
  }
  50% {
    transform: scale(1.3);
    filter: brightness(130%) drop-shadow(0 0 8px rgba(144, 195, 228, 0.7));
  }
  100% {
    transform: scale(1);
    filter: brightness(100%);
  }
}

/* Notification badge styling */
.notification-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background-color: #ff4d4f;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: bold;
  animation: pulse 1.5s infinite, scaleIn 0.5s ease;
}

@keyframes pulse {
  0% {
    transform: scale(1);
    box-shadow: 0 0 0 0 rgba(255, 77, 79, 0.7);
  }
  70% {
    transform: scale(1.2);
    box-shadow: 0 0 0 6px rgba(255, 77, 79, 0);
  }
  100% {
    transform: scale(1);
    box-shadow: 0 0 0 0 rgba(255, 77, 79, 0);
  }
}

@keyframes scaleIn {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

/* Comic-style notification popup */
.comic-popup {
  background-color: #fff;
  border: 3px solid #000;
  border-radius: 15px;
  box-shadow: 5px 5px 0 #000;
  padding: 1.5rem;
  position: relative;
  transform: translateY(-10px);
  opacity: 0;
  animation: slideIn 0.3s ease forwards;
}

.comic-popup::before {
  content: '';
  position: absolute;
  top: -20px;
  right: 20px;
  width: 0;
  height: 0;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 20px solid #000;
}

.comic-popup::after {
  content: '';
  position: absolute;
  top: -16px;
  right: 22px;
  width: 0;
  height: 0;
  border-left: 8px solid transparent;
  border-right: 8px solid transparent;
  border-bottom: 16px solid #fff;
}

.comic-title {
  font-family: 'Comic Sans MS', 'Chalkboard SE', sans-serif;
  font-size: 1.2rem;
  color: #000;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 1rem;
}

.comic-text {
  font-family: 'Comic Sans MS', 'Chalkboard SE', sans-serif;
  font-size: 0.9rem;
  color: #333;
}

.comic-popup a:hover {
  background-color: #f5f5f5;
  color: #90c3e4;
}

@keyframes slideIn {
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@media (max-width: 768px) {
  #sidebar {
    position: fixed;
    z-index: 1000;
    height: 100vh;
  }

  header {
    left: 80px !important;
  }

  .comic-popup {
    width: 250px;
    right: -10px;
  }
}
</style>