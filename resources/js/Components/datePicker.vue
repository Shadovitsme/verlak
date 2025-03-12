<template>
    <VDatePicker class="z-20" v-model="tempDate" mode="date" color="indigo">
        <template #footer>
            <div class="flex w-full gap-4 px-3 pb-3">
                <justButton
                    type="button"
                    color="gray"
                    class="w-full"
                    @click="cancelSelection"
                    >Отмена</justButton
                >
                <justButton
                    type="button"
                    color="blue"
                    class="w-full"
                    @click="confirmDate"
                    >Выбрать</justButton
                >
            </div>
        </template>
    </VDatePicker>
</template>
<script setup>
import { ref } from 'vue';
import justButton from './justButton.vue';
const tempDate = ref(null); // Временная дата, которая меняется при выборе в календаре
const emit = defineEmits(['update:selected-date', 'close']); // Определяем события

// Подтверждение выбора даты
const confirmDate = () => {
    if (tempDate.value) {
        emit('update:selected-date', tempDate.value); // Отправляем дату
    }
    emit('close'); // Закрываем календарь
};

// Отмена выбора
const cancelSelection = () => {
    emit('close'); // Просто закрываем календарь без передачи даты
};
</script>
<!-- https://vcalendar.io/?ref=madewithvuejs.com -->
