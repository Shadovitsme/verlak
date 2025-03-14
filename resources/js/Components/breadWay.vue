<script setup>
const props = defineProps({
    startPointText: String,
    currentPointText: String,
});
const emit = defineEmits(['gotoMain']);
</script>
<template>
    <div class="mb-5 flex gap-x-4">
        <p
            @click="emit('gotoMain')"
            class="my-auto text-sm text-gray-700 hover:underline"
        >
            {{ props.startPointText }}
        </p>
        <img class="size-5" src="/assets/icons/arrows/arrow-right-1.svg" />
        <p class="my-auto text-sm text-gray-700">
            {{ props.currentPointText }}
        </p>
    </div>
</template>
