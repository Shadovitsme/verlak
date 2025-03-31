<script setup>
import OpenModal from './openModal.vue';
import { ref } from 'vue';

const props = defineProps({
    text: String,
    id: String,
    table: String,
});

const openModal = ref(false);
</script>
<template>
    <OpenModal
        :id-to-delete="props.id"
        modal-type="deleteFile"
        :toggle-modal="openModal"
        @close="openModal = false"
        :speciall-add-data="{ table: props.table }"
    ></OpenModal>
    <div class="flex w-fit gap-x-5 rounded-lg bg-white px-4 py-3 shadow-sm">
        <p class="text-sm leading-tight text-gray-900">{{ props.text }}</p>
        <div class="flex h-4 gap-x-0.5">
            <img src="/assets/icons/system/download-file.svg" />
            <img
                @click="openModal = true"
                src="/assets/icons/system/delete.svg"
            />
        </div>
    </div>
</template>
