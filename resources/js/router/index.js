import { createRouter, createWebHistory } from 'vue-router';

import Catalog from '../views/Catalog.vue';
import MovieDetail from '../views/MovieDetail.vue';

const routes = [
  {
    path: '/',
    name: 'Catalog',
    component: Catalog,
  },
  {
    path: '/movie/:id',
    name: 'MovieDetail',
    component: MovieDetail,
    props: true,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;