import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import SQA from '../views/SQA.vue';
import Networking from '../views/Networking.vue';
import Candidates from '../views/Candidates.vue';
import Assessment from '../views/Assessment.vue';
import Settings from '../views/Settings.vue';
import SignOut from '../views/SignOut.vue';

const routes = [
  { path: '/', component: Dashboard }, // This will be /dashboard/
  { path: '/categories/sqa', component: SQA }, // This will be /dashboard/categories/sqa
  { path: '/categories/networking', component: Networking },
  { path: '/candidates', component: Candidates },
  { path: '/assessment', component: Assessment },
  { path: '/settings', component: Settings },
  { path: '/sign-out', component: SignOut },
];

const router = createRouter({
  history: createWebHistory('/dashboard'), // Set the base path to /dashboard
  routes,
});

export default router;