<template>
    <VDatePicker v-model="date" color="indigo">
        <template #footer>
            <div class="flex w-full gap-4 px-3 pb-3">
                <justButton color="gray" class="w-full" @click="setToday">Отмена</justButton>
                <justButton color="blue" class="w-full" @click="setToday">Выбрать</justButton>
            </div>
        </template>
    </VDatePicker>
</template>
<script setup>
import { ref } from 'vue';
import justButton from './justButton.vue';
const date = ref(new Date());
function setToday() {
    date.value = new Date();
}
</script>
<!-- https://vcalendar.io/?ref=madewithvuejs.com -->
