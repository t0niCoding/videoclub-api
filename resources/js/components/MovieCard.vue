<!-- resources/js/components/MovieCard.vue -->
<template>
    <div class="border p-4 rounded shadow hover:shadow-lg transition">
      <img
        :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
        :alt="movie.title"
        class="mb-2 w-full h-auto rounded"
      />
      <h3 class="text-lg font-semibold">{{ movie.title }}</h3>
      <p class="text-sm text-gray-600">{{ movie.release_date }}</p>
      <div class="text-sm mt-2">
        <span
          v-for="genre in movie.genres"
          :key="genre.genre_id"
          class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded mr-1 mb-1"
        >
          {{ genre.genre_name }}
        </span>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    movie: Object
  });
  </script>
  