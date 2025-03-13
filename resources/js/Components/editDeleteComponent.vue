<script setup>
import { ref } from 'vue';
import OpenModal from './openModal.vue';
const emit = defineEmits(['editable', 'deleteId']);
let toggleModal = ref('false');
const props = defineProps({
    modalType: String,
    idToDelete: String,
});
</script>

<template>
    <OpenModal
        :idToDelete="props.idToDelete"
        :toggle-modal="toggleModal"
        @close="toggleModal = !toggleModal"
        :modal-type="props.modalType"
    ></OpenModal>
    <div class="flex gap-3">
        <!-- TODO вынести перекрашивание свг в отдельную жс функцию -->
        <img @click="emit('editable')" src="/assets/icons/system/edit.svg" />
        <img
            @click="toggleModal = !toggleModal"
            src="/assets/icons/system/delete.svg"
        />
    </div>
</template>
