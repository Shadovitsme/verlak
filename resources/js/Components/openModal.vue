<script setup>
import Modal from '@/Components/Modal.vue';
import modalField from './modalField.vue';
import deleteTemplate from './modalTemplates/deleteTemplate.vue';
import AddManager from './modalTemplates/addManager.vue';
import universalDelete from './jsFunctions/deleteFunc/universalDelete';
import addNewManager from './jsFunctions/setters/addNewManager';
import { ref } from 'vue';
import deleteElevator from './jsFunctions/deleteFunc/deleteElevator';
import AddFileTemplate from './modalTemplates/addFileTemplate.vue';
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
// TODO сделать это через поиск слова в массиве
if (
    props.modalType == 'deleteManager' ||
    props.modalType == 'deleteContract' ||
    props.modalType == 'deleteAdress' ||
    props.modalType == 'deleteEntrance' ||
    props.modalType == 'deleteElevator' ||
    props.modalType == 'deleteBuildingData' ||
    props.modalType == 'deleteContact' ||
    props.modalType == 'deleteContactListItem' ||
    props.modalType == 'deletePhoto' ||
    props.modalType == 'deleteMontazh' ||
    props.modalType == 'deleteWorker' ||
    props.modalType == 'deleteAvans' ||
    props.modalType == 'deleteODSH' ||
    props.modalType == 'deleteFile'
) {
    submitButtonText = 'Удалить';
    selectText(props.modalType);
} else {
    submitButtonText = 'Добавить';
    deleteForm.value = false;
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
        case 'deletePhoto':
            top.value = 'Удалить фото';
            body.value = 'Вы уверены, что хотите удалить приложенный файл?';
            break;
        case 'deleteMontazh':
            top.value = 'Удалить монтажника';
            body.value = 'Вы уверены, что хотите удалить данные монтажника?';
            break;
        case 'deleteWorker':
            top.value = 'Удалить исполнителя';
            body.value = 'Вы уверены, что хотите удалить данные исполнителя?';
            break;
        case 'deleteAvans':
            top.value = 'Удалить аванс';
            body.value = 'Вы уверены, что хотите удалить аванс?';
            break;
        case 'deleteODSH':
            top.value = 'Удалить этаж';
            body.value = 'Вы уверены, что хотите удалить этаж?';
            break;
        case 'deleteFile':
            top.value = 'Удалить фаил';
            body.value = 'Вы уверены, что хотите удалить фаил?';
            break;
        default:
            break;
    }
}
const fileUploadRef = ref(null);
async function send() {
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
        case 'deletePhoto':
            universalDelete(
                props.idToDelete,
                '/universalDelete',
                'adressPhoto',
            );
            break;
        case 'deleteMontazh':
            universalDelete(props.idToDelete, '/universalDelete', 'montazh');
            break;
        case 'deleteMaterial':
            universalDelete(
                props.idToDelete,
                '/universalDelete',
                'buildingMaterial',
            );
            break;
        case 'deleteAvans':
            universalDelete(props.idToDelete, '/universalDelete', 'avances');
            break;
        case 'deleteWorker':
            universalDelete(props.idToDelete, '/universalDelete', 'worker');
            break;
        case 'deleteODSH':
            universalDelete(props.idToDelete, '/universalDelete', 'ODSHTable');
            break;
        case 'deleteFile':
            universalDelete(
                props.idToDelete,
                '/universalDelete',
                props.speciallAddData.table,
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
        case 'addFile':
            await fileUploadRef.value.uploadFile();

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
            <AddFileTemplate
                :folder="props.speciallAddData.folder"
                :fatherId="props.speciallAddData.fatherId"
                :tableName="props.speciallAddData.tableName"
                ref="fileUploadRef"
                v-if="props.modalType == 'addFile'"
            ></AddFileTemplate>
        </modalField>
    </Modal>
</template>
