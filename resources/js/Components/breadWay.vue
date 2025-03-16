<script setup>
const props = defineProps({
    startPointText: String,
    middlePointText: String,
    currentPointText: String,
});
const emit = defineEmits(['gotoMain', 'gotoMIddle']);
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
        <p
            v-if="props.middlePointText"
            @click="emit('gotoMiddle')"
            class="my-auto text-sm text-gray-700 hover:underline"
        >
            {{ props.middlePointText }}
        </p>
        <img
            v-if="props.middlePointText"
            class="size-5"
            src="/assets/icons/arrows/arrow-right-1.svg"
        />
        <p class="my-auto text-sm text-gray-700">
            {{ props.currentPointText }}
        </p>
    </div>
</template>
