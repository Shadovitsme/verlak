<script setup>
import CustomInput from './customInput.vue';
import JustButton from './justButton.vue';
import addEntrance from './jsFunctions/setters/addNewEntrance';
const emit = defineEmits(['close']);
const props = defineProps(['id']);

function save() {
    event.preventDefault();
    addEntrance(
        props.id,
        document
            .getElementById('entranceNumber')
            .getElementsByTagName('input')[0].value,
    );

    emit('close');
}
</script>
<template>
    <div
        class="flex w-full items-center justify-between rounded-lg bg-white px-4 py-2"
    >
        <form @submit.prevent="save" class="flex items-center gap-3">
            <CustomInput
                id="entranceNumber"
                :static-width="true"
                placeholder="Введите номер подъезда"
            ></CustomInput
            ><JustButton type="sumbit" color="blue">Сохранить</JustButton>
        </form>
        <img @click="emit('close')" src="/assets/icons/system/delete.svg" />
    </div>
</template>
