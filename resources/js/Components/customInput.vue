<script setup>
const props = defineProps({
    labelText: String,
    placeholder: String,
    staticWidth: Boolean,
    value: String,
    inputType: String, // Добавляем пропс для типа инпута
});

const emit = defineEmits(['update:value', 'inputType']); // Объявляем события для v-model

const handleInput = (event) => {
    emit('update:value', event.target.value);
};
</script>

<template>
    <div :class="props.staticWidth ? 'w-[364px]' : 'w-full'">
        <p class="mb-1.5 text-sm text-gray-900">{{ props.labelText }}</p>
        <input
            :type="props.inputType || 'text'"
            class="h-fit rounded-lg border-[1px] border-gray-300 bg-gray-50 px-4 py-3.5 text-base text-gray-900 placeholder:text-gray-500"
            :placeholder="props.placeholder"
            :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
            :value="props.value"
            @input="handleInput"
        />
    </div>
</template>
