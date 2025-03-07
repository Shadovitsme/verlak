<script setup lang="ts">
import IconButton from './iconButton.vue';
import JustButton from './justButton.vue';
let notificateStatus = 'Default';
</script>
<template>
    <div
        class="fixed top-0 mx-auto flex h-20 w-full max-w-[1600px] bg-white pl-28 pr-32"
    >
        <div class="my-auto flex h-fit w-full justify-between">
            <div class="flex gap-3">
                <JustButton color="noColor">Договоры</JustButton
                ><JustButton color="noColor">Сотрудники</JustButton
                ><JustButton color="noColor">Счета</JustButton
                ><JustButton class="flex align-middle" color="noColor"
                    >Уведомления
                    <img
                        class="imgColorlessButton ml-2 inline-block size-5"
                        :src="
                            '/assets/icons/system/State=' +
                            notificateStatus +
                            '.svg'
                        "
                /></JustButton>
                <!-- TODO сделать отдельный класс для таких текстов с иконками чтоб красить иконку -->
                <!-- TODO заставить колокольчик подкрашиваться при наведении на кнопку-->
                <JustButton color="noColor">Исполнители</JustButton>
            </div>
            <div class="flex">
                <p class="my-auto mr-3.5 flex font-medium text-indigo-600">
                    ivan@mail.ru
                </p>
                <IconButton
                    color="gray"
                    icon="/assets/icons/system/log-out.svg"
                ></IconButton>
            </div>
        </div>
    </div>
</template>
<style>
.imgColorlessButton:hover {
    filter: brightness(0) saturate(100%) invert(20%) sepia(83%) saturate(3179%)
        hue-rotate(242deg) brightness(80%) contrast(96%);
}
</style>
