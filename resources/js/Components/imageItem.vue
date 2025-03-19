<script setup>
const props = defineProps({
    stc: String,
});
</script>
<template>
    <img class="h-52 shrink-0 rounded-lg" :src="props.src" />
</template>
