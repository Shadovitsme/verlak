<script setup>
import { ref } from 'vue';
import DatePicker from '../datePicker.vue';
const props = defineProps({
    labelText: String,
    placeholder: String,
    staticWidth: Boolean,
    value: String,
});

const emit = defineEmits(['update:value']); // Для v-model

let showDrop = ref(false);
let selectedDate = ref(props.value); // Реактивная переменная для хранения выбранной даты

// Обработка выбранной даты
const handleDateUpdate = (date) => {
    selectedDate.value = date;
    const formattedDate = formatDate(date);
    emit('update:value', formattedDate);
};

const formatDate = (date) => {
    if (!date) return null;
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // +1 так как месяцы начинаются с 0
    const year = date.getFullYear();
    return `${day}.${month}.${year}`;
};

function clearSelected() {
    selectedDate.value = '';
    emit('update:value', '');
}

// Закрытие календаря
const closeCalendar = () => {
    showDrop.value = false;
};
</script>

<template>
    <div class="z-0 h-10 w-full">
        <div
            class="relative z-0"
            :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
        >
            <p class="mb-1.5 text-sm text-gray-900">{{ props.labelText }}</p>
            <button
                @click="showDrop = !showDrop"
                type="button"
                class="flex h-12 items-center justify-between rounded-lg border-[1px] border-gray-300 bg-gray-50 px-4 text-left text-sm text-gray-500"
                :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
            >
                {{
                    selectedDate
                        ? selectedDate.toLocaleDateString()
                        : props.placeholder
                }}
                <img
                    @click="clearSelected"
                    v-if="selectedDate"
                    class="h-3"
                    src="/assets/icons/system/x.svg"
                />
            </button>
            <div v-if="showDrop" class="absolute right-0 mt-1.5">
                <DatePicker
                    @update:selected-date="handleDateUpdate"
                    @close="closeCalendar"
                />
            </div>
        </div>
    </div>
</template>
