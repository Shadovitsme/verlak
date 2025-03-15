<script setup>
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import DeleteManager from './modalTemplates/deleteManager.vue';
import AddManager from './modalTemplates/addManager.vue';
import DeleteManagerFromDb from './jsFunctions/deleteFunc/deleteManagerFromDb';
import addNewManager from './jsFunctions/setters/addNewManager';
const emit = defineEmits(['close']);

const props = defineProps({
    modalType: String,
    toggleModal: Boolean,
    idToDelete: Number,
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

function send() {
    event.preventDefault();

    let elements = event.target.elements;
    switch (props.modalType) {
        case 'deleteManager':
            DeleteManagerFromDb(props.idToDelete);
            break;
        case 'addManager':
            addNewManager(
                elements[0].value,
                elements[1].value,
                elements[2].value,
                elements[3].value,
            );
            break;
        default:
            break;
    }

    emit('close');
}
</script>
<template>
    <Modal :show="props.toggleModal">
        <modalField
            @close="emit('close')"
            @submit="send()"
            :submitButtonText="submitButtonText"
        >
            <DeleteManager
                v-if="props.modalType == 'deleteManager'"
            ></DeleteManager>
            <AddManager v-if="props.modalType == 'addManager'"></AddManager>
        </modalField>
    </Modal>
</template>
