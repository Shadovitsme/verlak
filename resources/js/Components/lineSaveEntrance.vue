<script setup>
import CustomInput from './customInput.vue';
import JustButton from './justButton.vue';
import addEntrance from './jsFunctions/setters/addNewEntrance';
import addContactFolder from './jsFunctions/setters/addContactFolder';
const emit = defineEmits(['close']);
const props = defineProps(['id', 'place']);

function save() {
    event.preventDefault();
    let name = document
        .getElementById(props.place)
        .getElementsByTagName('input')[0].value;
    switch (props.place) {
        case 'entrance':
            addEntrance(props.id, name);
            break;
        case 'contact':
            addContactFolder(props.id, name);
            break;

        default:
            break;
    }

    emit('close');
}
</script>
<template>
    <div
        class="flex w-full items-center justify-between rounded-lg bg-white px-4 py-2"
    >
        <form @submit.prevent="save" class="flex items-center gap-3">
            <CustomInput
                :id="props.place"
                :static-width="true"
                placeholder="Введите номер подъезда"
            ></CustomInput
            ><JustButton type="sumbit" color="blue">Сохранить</JustButton>
        </form>
        <img @click="emit('close')" src="/assets/icons/system/delete.svg" />
    </div>
</template>
