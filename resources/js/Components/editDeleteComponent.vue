<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import DeleteManager from './modalTemplates/deleteManager.vue';
const emit = defineEmits(['editable']);
let toggleModal = ref('false');
const props = defineProps({
    modalType: String,
});
let submitButtonText;
if (props.modalType == 'deleteManager') {
    submitButtonText = 'Удалить';
}
</script>

<template>
    <Modal @click="toggleModal = !toggleModal" :show="toggleModal">
        <modalField :submitButtonText="submitButtonText">
            <DeleteManager
                v-if="props.modalType == 'deleteManager'"
            ></DeleteManager>
        </modalField>
    </Modal>
    <div class="flex gap-3">
        <!-- TODO вынести перекрашивание свг в отдельную жс функцию -->
        <img @click="emit('editable')" src="/assets/icons/system/edit.svg" />
        <img
            @click="toggleModal = !toggleModal"
            src="/assets/icons/system/delete.svg"
        />
    </div>
</template>
