<script setup>
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import DeleteManager from './modalTemplates/deleteManager.vue';
import AddManager from './modalTemplates/addManager.vue';
const emit = defineEmits(['close']);

const props = defineProps({
    modalType: String,
    toggleModal: Boolean,
});
let submitButtonText;

switch (props.modalType) {
    case 'deleteManager':
        submitButtonText = 'Удалить';
        break;
    case 'addManager':
        submitButtonText = 'Добавить';
        break;
    default:
        break;
}
</script>
<template>
    <Modal :show="props.toggleModal">
        <modalField @close="emit('close')" :submitButtonText="submitButtonText">
            <DeleteManager
                v-if="props.modalType == 'deleteManager'"
            ></DeleteManager>
            <AddManager v-if="props.modalType == 'addManager'"></AddManager>
        </modalField>
    </Modal>
</template>
