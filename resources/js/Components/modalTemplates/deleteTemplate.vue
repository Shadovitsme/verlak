<script setup>
const props = defineProps({
    top: String,
    body: String,
});
</script>
<template>
    <h1 class="mb-5 text-center text-2xl text-gray-900">{{ props.top }}</h1>
    <p class="text-sm text-gray-900">
        {{ props.body }}
    </p>
</template>
