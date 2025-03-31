<script setup>
import { ref } from 'vue';

const props = defineProps({
    staticWidth: Boolean,
    labelTextArr: Array,
    placeholder: String,
});

const showDrop = ref(false);
const val = ref([]); // Массив выбранных элементов

const emit = defineEmits(['update:value']); // Для v-model

// Функция обработки изменения состояния чекбокса
function handleCheckboxChange(event, text) {
    const isChecked = event.target.checked;

    if (isChecked) {
        // Добавляем элемент, если его еще нет в массиве
        if (!val.value.includes(text)) {
            val.value.push(text);
        }
    } else {
        // Удаляем элемент при снятии галочки
        val.value = val.value.filter((item) => item !== text);
    }

    // Отправляем обновленное значение через emit для v-model
    emit('update:value', val.value);
}
</script>

<template>
    <div
        class="z-10 mt-1.5 h-10"
        :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
    >
        <div :class="props.staticWidth ? 'w-[364px]' : 'w-full'">
            <button
                @click="showDrop = !showDrop"
                type="button"
                class="h-12 rounded-lg border-[1px] border-gray-300 bg-gray-50 px-4 text-left text-sm text-gray-500"
                :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
            >
                {{
                    props.placeholder +
                    (val.length > 0 ? ' (' + val.length + ')' : '')
                }}
            </button>
        </div>
        <div
            v-if="showDrop"
            class="z-10 mt-1.5 h-fit max-h-40 w-full space-y-3 overflow-y-auto overflow-x-visible rounded-lg bg-white p-4 shadow-sm"
            :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
        >
            <div v-for="text in props.labelTextArr" :key="text">
                <input
                    :id="text"
                    :value="text"
                    type="checkbox"
                    class="mr-2"
                    :checked="val.includes(text)"
                    @change="handleCheckboxChange($event, text)"
                />
                <label class="text-sm text-gray-900" :for="text">{{
                    text
                }}</label>
            </div>
        </div>
    </div>
</template>
