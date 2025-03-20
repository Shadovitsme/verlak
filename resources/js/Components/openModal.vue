<script setup>
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import deleteTemplate from './modalTemplates/deleteTemplate.vue';
import AddManager from './modalTemplates/addManager.vue';
import universalDelete from './jsFunctions/deleteFunc/universalDelete';
import addNewManager from './jsFunctions/setters/addNewManager';
import { ref } from 'vue';
import deleteElevator from './jsFunctions/deleteFunc/deleteElevator';
const emit = defineEmits(['close']);

const props = defineProps({
    modalType: String,
    toggleModal: Boolean,
    idToDelete: Number,
    speciallAddData: Object,
});
let submitButtonText;
let deleteForm = ref(true);
let top = ref();
let body = ref();

if (
    props.modalType == 'deleteManager' ||
    props.modalType == 'deleteContract' ||
    props.modalType == 'deleteAdress' ||
    props.modalType == 'deleteEntrance' ||
    props.modalType == 'deleteElevator' ||
    props.modalType == 'deleteBuildingData' ||
    props.modalType == 'deleteContact' ||
    props.modalType == 'deleteContactListItem'
) {
    submitButtonText = 'Удалить';
    selectText(props.modalType);
} else {
    switch (props.modalType) {
        case 'addManager':
            submitButtonText = 'Добавить';
            deleteForm.value = false;
            break;
        default:
            break;
    }
}

function selectText(type) {
    switch (type) {
        case 'deleteManager':
            top.value = 'Удалить сотрудника';
            body.value = 'Вы уверены, что хотите удалить данные менеджера?';
            break;
        case 'deleteContract':
            top.value = 'Удалить договор';
            body.value = 'Вы уверены, что хотите удалить договор?';
            break;
        case 'deleteAdress':
            top.value = 'Удалить адрес';
            body.value = 'Вы уверены, что хотите удалить адрес?';
            break;
        case 'deleteEntrance':
            top.value = 'Удалить подъезд';
            body.value = 'Вы уверены, что хотите удалить подъезд?';
            break;
        case 'deleteElevator':
            top.value = 'Удалить лифт';
            body.value = 'Вы уверены, что хотите удалить лифт?';
            break;
        case 'deleteBuildingData':
            top.value = '';
            body.value = '';
            break;
        case 'deleteContact':
            top.value = 'Удалить контакт';
            body.value = 'Вы уверены, что хотите удалить контактное лицо?';
            break;
        case 'deleteContactListItem':
            top.value = 'Удалить организацию';
            body.value = 'Вы уверены, что хотите удалить организацию?';
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
            universalDelete(props.idToDelete, '/universalDelete', 'contract');
            break;
        case 'deleteAdress':
            universalDelete(props.idToDelete, '/universalDelete', 'adressData');
            break;
        case 'deleteEntrance':
            universalDelete(props.idToDelete, '/deleteEntrance');
            break;
        case 'deleteBuildingData':
            universalDelete(
                props.idToDelete,
                '/deleteBuildingData',
                props.speciallAddData.adressId,
            );
            break;
        case 'deleteContact':
            universalDelete(
                props.idToDelete,
                '/universalDelete',
                'contactPerson',
            );
            break;
        case 'deleteElevator':
            deleteElevator(
                props.speciallAddData.name,
                props.speciallAddData.adressId,
                props.speciallAddData.entrance,
            );
            break;
        case 'deleteContactListItem':
            universalDelete(
                props.idToDelete,
                '/universalDelete',
                'contactList',
            );
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
                v-if="deleteForm"
                :top="top"
                :body="body"
            ></deleteTemplate>
            <AddManager v-if="props.modalType == 'addManager'"></AddManager>
        </modalField>
    </Modal>
</template>
