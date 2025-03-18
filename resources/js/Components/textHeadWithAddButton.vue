<script setup>
import IconButton from './iconButton.vue';
const props = defineProps({
    shown: Boolean,
    text: String,
});
const emit = defineEmits(['addItem']);
</script>
<template>
    <div class="mb-5 flex h-fit content-center items-center">
        <p class="my-auto mr-4 text-2xl text-gray-900">{{ props.text }}</p>
        <IconButton
            @click="emit('addItem')"
            v-if="props.shown"
            type="button"
            class="my-auto rotate-45"
            icon="/assets/icons/system/x.svg"
            color="blue"
        ></IconButton>
    </div>
</template>
