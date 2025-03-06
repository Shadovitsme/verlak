<script setup lang="ts">
import JustButton from './justButton.vue';
</script>
<!-- TODO закостомить макс в -1600пх -->
<template>
    <div class="fixed top-0 mx-auto flex h-20 w-full max-w-[1600px] bg-white">
        <div class="my-auto flex h-fit w-full justify-between">
            <div class="flex gap-3">
                <JustButton color="noColor">Договоры</JustButton
                ><JustButton color="noColor">Сотрудники</JustButton
                ><JustButton color="noColor">Счета</JustButton
                ><JustButton color="noColor">Уведомления</JustButton>
                <!-- TODO уведомлениям нужен колокольчик -->
                <JustButton color="noColor">Исполнители</JustButton>
            </div>
            <div class="flex">
                <p class="my-auto font-medium text-indigo-600">ivan@mail.ru</p>
            </div>
        </div>
    </div>
</template>
