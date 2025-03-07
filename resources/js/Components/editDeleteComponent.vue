<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

let toggleModal = ref('false');
</script>

<template>
    <Modal @click="toggleModal = !toggleModal" :show="toggleModal"></Modal>

    <div class="flex gap-3">
        <!-- TODO вынести перекрашивание свг в отдельную жс функцию -->
        <img src="/assets/icons/system/edit.svg" />
        <img
            @click="toggleModal = !toggleModal"
            src="/assets/icons/system/delete.svg"
        />
    </div>
</template>
