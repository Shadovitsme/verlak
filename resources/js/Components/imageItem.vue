<script setup>
import OpenModal from './openModal.vue';
import { ref } from 'vue';

const props = defineProps({
    src: String,
    id: String,
});
let toggleModal = ref(false);
</script>

<template>
    <OpenModal
        @close="toggleModal = !toggleModal"
        modal-type="deletePhoto"
        :id-to-delete="props.id"
        :toggle-modal="toggleModal"
    ></OpenModal>
    <div class="relative inline-block">
        <img class="h-52 w-auto shrink-0 rounded-lg" :src="props.src" />
        <div
            class="absolute right-2 top-2 flex items-center justify-center gap-0.5 rounded-lg bg-gray-500 px-2 py-1 opacity-75"
        >
            <img
                class="size-4"
                src="/assets/icons/system/download-file.svg"
                style="
                    filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg)
                        brightness(100%) contrast(100%);
                    opacity: 1;
                "
            />
            <img
                @click="toggleModal = !toggleModal"
                class="size-4"
                src="/assets/icons/system/delete.svg"
                style="
                    filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg)
                        brightness(100%) contrast(100%);
                    opacity: 1;
                "
            />
        </div>
    </div>
</template>
