<script setup lang="ts">
import PhotoCard from './photoCard.vue';
</script>

<template>
    <div>
        <p class="mb-3 text-2xl text-gray-900">Фото объекта</p>
        <PhotoCard v-for="item in 5" :key="item"></PhotoCard>
    </div>
</template>
