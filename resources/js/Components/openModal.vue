<script setup>
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import deleteTemplate from './modalTemplates/deleteTemplate.vue';
import AddManager from './modalTemplates/addManager.vue';
import universalDelete from './jsFunctions/deleteFunc/universalDelete';
import addNewManager from './jsFunctions/setters/addNewManager';
const emit = defineEmits(['close']);

const props = defineProps({
    modalType: String,
    toggleModal: Boolean,
    idToDelete: Number,
});
let submitButtonText;

if (props.modalType == 'deleteManager' || props.modalType == 'deleteContract') {
    submitButtonText = 'Удалить';
} else {
    switch (props.modalType) {
        case 'addManager':
            submitButtonText = 'Добавить';
            break;
        default:
            break;
    }
}

function send() {
    event.preventDefault();

    let elements = event.target.elements;
    switch (props.modalType) {
        case 'deleteManager':
            universalDelete(props.idToDelete, '/deleteManager');
            break;
        case 'deleteContract':
            universalDelete(props.idToDelete, '/deleteContract');
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
            <deleteTemplate
                top="Удалить сотрудника"
                body="  Вы уверены, что хотите удалить данные менеджера?"
                v-if="props.modalType == 'deleteManager'"
            ></deleteTemplate>
            <deleteTemplate
                top="Удалить договор"
                body="  Вы уверены, что хотите удалить договор ?"
                v-if="props.modalType == 'deleteContract'"
            ></deleteTemplate>
            <AddManager v-if="props.modalType == 'addManager'"></AddManager>
        </modalField>
    </Modal>
</template>
