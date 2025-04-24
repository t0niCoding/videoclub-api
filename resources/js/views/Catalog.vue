<template>
  <div class="p-4 max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-blue-600">Catálogo de Películas</h1>

    <!-- FILTROS -->
    <div class="flex gap-4 mb-4">
      <!-- Selector de Género -->
      <select v-model="selectedGenre" @change="fetchMovies(1)" class="border rounded p-2">
        <option value="">Todos los géneros</option>
        <option v-for="genre in genres" :key="genre.id" :value="genre.id">
          {{ genre.name }}
        </option>
      </select>
      <!-- Selector de Año -->
      <input type="text" v-model="selectedYear" @keyup.enter="fetchMovies(1)" placeholder="Filtrar por año (ej. 1994)"
        class="border rounded p-2" />
    </div>

    <!-- LISTA DE PELÍCULAS -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
      <router-link v-for="movie in movies" :key="movie.id" :to="`/movie/${movie.id}`"
        class="block bg-white rounded shadow hover:shadow-lg transition">
        <img :src="getImageUrl(movie.poster_path)" class="rounded-t" />
        <div class="p-2">
          <h2 class="text-sm font-semibold truncate">{{ movie.title }}</h2>
          <p class="text-xs text-gray-500">{{ movie.release_date }}</p>
        </div>
      </router-link>
    </div>

    <!-- PAGINADOR -->
    <div class="flex justify-center items-center gap-4 mt-6">
      <!-- Botón Anterior -->
      <button @click="fetchMovies(currentPage - 1)" :disabled="!pagination.prev" class="px-3 py-1 border rounded">
        ← Anterior
      </button>

      <!-- Página actual -->
      <span>Página {{ currentPage }} / {{ pagination.last_page }}</span>

      <!-- Botón Siguiente -->
      <button @click="fetchMovies(currentPage + 1)" :disabled="!pagination.next" class="px-3 py-1 border rounded">
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

onMounted(async () => {
  await fetchMovies();
  await fetchGenres();
});

const fetchGenres = async () => {
  try {
    const { data } = await axios.get('http://127.0.0.1:8000/api/genres');
    genres.value = data.data ?? data;
  } catch (err) {
    console.error('Error cargando géneros:', err);
  }
};
</script>
