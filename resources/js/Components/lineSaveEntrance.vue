<script setup>
import CustomInput from './customInput.vue';
import JustButton from './justButton.vue';
</script>
<template>
    <div
        class="flex w-full items-center justify-between rounded-lg bg-white px-4 py-2"
    >
        <div class="flex gap-3">
            <CustomInput
                :static-width="true"
                placeholder="Введите номер подъезда"
            ></CustomInput
            ><JustButton color="blue">Сохранить</JustButton>
        </div>
        <img src="/assets/icons/system/delete.svg" />
    </div>
</template>
