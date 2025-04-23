<template>
    <div v-if="movie" class="p-4">
      <img :src="imageUrl" :alt="movie.title" class="w-full max-w-md mx-auto mb-4 rounded">
      <h1 class="text-2xl font-bold mb-2">{{ movie.title }}</h1>
      <p class="mb-2">Fecha de estreno: {{ movie.release_date }}</p>
      <div class="mb-4">
        <strong>Géneros:</strong>
        <span v-for="genre in movie.genres" :key="genre.genre_id" class="mr-2">
          {{ genre.genre_name }}
        </span>
      </div>
      <router-link to="/" class="text-blue-600 hover:underline">← Volver al catálogo</router-link>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue';
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  
  const route = useRoute();
  const movie = ref(null);
  
  onMounted(async () => {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/movies?movie_id=${route.params.id}`);
      movie.value = response.data.data[0];
    } catch (error) {
      console.error('Error al cargar detalles:', error);
    }
  });
  
  const imageUrl = computed(() =>
    movie.value ? `https://image.tmdb.org/t/p/w500${movie.value.poster_path}` : ''
  );
  </script>
  