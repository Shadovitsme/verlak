<script setup>
const props = defineProps({
    labelText: String,
    placeholder: String,
    staticWidth: Boolean,
    value: String,
    inputType: String, // Добавляем пропс для типа инпута
    errorState: Boolean,
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
            :data-error="props.error"
            class="invalid:bg-red h-12 rounded-lg border-[1px] px-4 py-3.5 text-base text-gray-900 duration-300"
            :class="[
                props.staticWidth ? 'w-[364px]' : 'w-full',
                props.errorState
                    ? 'border-red-500 bg-rose-50 placeholder:text-rose-500'
                    : 'border-gray-300 bg-gray-50 placeholder:text-gray-500',
                props.inputType === 'number'
                    ? '[appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none'
                    : '',
            ]"
            :placeholder="props.placeholder"
            :value="props.value"
            @input="handleInput"
        />
    </div>
</template>
