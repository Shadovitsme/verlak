<script setup>
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import DeleteManager from './modalTemplates/deleteManager.vue';
const emit = defineEmits(['close']);

const props = defineProps({
    modalType: String,
    toggleModal: Boolean,
});
let submitButtonText;
if (props.modalType == 'deleteManager') {
    submitButtonText = 'Удалить';
}
</script>
<template>
    <Modal :show="props.toggleModal">
        <modalField @close="emit('close')" :submitButtonText="submitButtonText">
            <DeleteManager
                v-if="props.modalType == 'deleteManager'"
            ></DeleteManager>
        </modalField>
    </Modal>
</template>
