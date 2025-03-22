<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

// Определяем пропсы
const props = defineProps({
    align: { type: String, default: 'right' },
    width: { type: String, default: '48' },
    contentClasses: { type: String, default: 'py-1 bg-white' },
    items: { type: Array, default: () => [] }, // Пропс для данных
});

// Определяем события
const emit = defineEmits(['select']);

// Состояние открытия
const open = ref(false);

// Закрытие по клавише Escape
const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') open.value = false;
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

// Вычисляемые классы ширины
const widthClass = computed(
    () =>
        ({
            48: 'w-48',
        })[props.width.toString()],
);

// Вычисляемые классы выравнивания
const alignmentClasses = computed(() => {
    if (props.align === 'left')
        return 'ltr:origin-top-left rtl:origin-top-right start-0';
    if (props.align === 'right')
        return 'ltr:origin-top-right rtl:origin-top-left end-0';
    return 'origin-top';
});

// Функция выбора элемента
const selectItem = (item) => {
    emit('select', item);
    open.value = false;
};
</script>

<template>
    <div class="relative">
        <!-- Триггер -->
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Оверлей для закрытия -->
        <div
            v-show="open"
            class="fixed inset-0 z-40"
            @click="open = false"
        ></div>

        <!-- Анимация выпадающего меню -->
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-2 rounded-md shadow-lg"
                :class="[widthClass, alignmentClasses]"
            >
                <div
                    class="rounded-md ring-1 ring-black ring-opacity-5"
                    :class="contentClasses"
                >
                    <!-- Список элементов из пропса items -->
                    <ul v-if="items.length > 0">
                        <li
                            v-for="(item, index) in items"
                            :key="index"
                            class="cursor-pointer px-4 py-2 hover:bg-gray-100"
                            @click="selectItem(item)"
                        >
                            {{ item.name || item }}
                        </li>
                    </ul>
                    <!-- Слот по умолчанию, если items пустой -->
                    <slot v-else name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
