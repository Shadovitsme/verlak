<script setup>
import JustButton from '@/Components/justButton.vue';
const props = defineProps({
    value: String,
    placeholder: { type: String, default: () => 'Оставьте комментарий' },
});
const emit = defineEmits(['save', 'update:value', 'inputType']);
const handleInput = (event) => {
    emit('update:value', event.target.value);
};
</script>
<template>
    <p class="text-sm text-gray-900">Комментарий</p>
    <div
        class="relative mt-1.5 min-h-36 w-128 overflow-hidden rounded-lg border-[1px] border-gray-300 bg-gray-50"
    >
        <textarea
            maxlength="100"
            @input="handleInput"
            :value="props.value"
            :placeholder="props.placeholder"
            class="h-fit min-h-36 w-full resize-none border-none bg-gray-50 pb-16 outline-none placeholder:text-gray-500 focus:border-none focus:outline-none"
        >
        </textarea>
        <div
            class="absolute bottom-0 left-0 right-0 flex justify-end border-t-[1px] border-gray-300 bg-gray-50 p-3"
        >
            <JustButton @click="emit('save')" color="blue"
                >Сохранить</JustButton
            >
        </div>
    </div>
</template>
