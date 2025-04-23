<template>
  <div class="p-4 max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-blue-600">Catálogo de Películas</h1>

    <!-- FILTROS -->
    <div class="flex flex-wrap gap-4 mb-6">
      <select v-model="selectedGenre" @change="fetchMovies(1)" class="border rounded p-2">
        <option value="">Todos los géneros</option>
        <option v-for="genre in genres" :key="genre.genre_id" :value="genre.genre_id">
          {{ genre.genre_name }}
        </option>
      </select>

      <select v-model="selectedYear" @change="fetchMovies(1)" class="border rounded p-2">
        <option value="">Todos los años</option>
        <option v-for="year in releaseYears" :key="year" :value="year">{{ year }}</option>
      </select>
    </div>

    <!-- LISTA DE PELÍCULAS -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
      <router-link
        v-for="movie in movies"
        :key="movie.id"
        :to="`/movie/${movie.id}`"
        class="block bg-white rounded shadow hover:shadow-lg transition"
      >
        <img :src="getImageUrl(movie.poster_path)" class="rounded-t" />
        <div class="p-2">
          <h2 class="text-sm font-semibold truncate">{{ movie.title }}</h2>
          <p class="text-xs text-gray-500">{{ movie.release_date }}</p>
        </div>
      </router-link>
    </div>

    <!-- PAGINADOR -->
    <div class="flex justify-center items-center gap-4 mt-6">
      <button
        @click="fetchMovies(currentPage - 1)"
        :disabled="!pagination.prev"
        class="px-3 py-1 border rounded"
      >
        ← Anterior
      </button>

      <span>Página {{ currentPage }} / {{ pagination.last_page }}</span>

      <button
        @click="fetchMovies(currentPage + 1)"
        :disabled="!pagination.next"
        class="px-3 py-1 border rounded"
      >
        Siguiente →
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const movies = ref([]);
const pagination = ref({});
const currentPage = ref(1);

const selectedGenre = ref('');
const selectedYear = ref('');

const genres = ref([]);
const releaseYears = Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i);

const getImageUrl = (path) => `https://image.tmdb.org/t/p/w300${path}`;

const fetchMovies = async (page = 1) => {
  try {
    currentPage.value = page;

    const params = {
      page,
      ...(selectedGenre.value && { genre_id: selectedGenre.value }),
      ...(selectedYear.value && { release_date: selectedYear.value }),
    };

    const { data } = await axios.get('http://127.0.0.1:8000/api/movies', { params });

    movies.value = data.data;
    pagination.value = data.meta;
    pagination.value.next = data.links.next;
    pagination.value.prev = data.links.prev;
  } catch (err) {
    console.error('Error cargando películas:', err);
  }
};

onMounted(() => {
  fetchMovies();
});
</script>
