<script setup>
const props = defineProps({
    state: Boolean,
});
</script>
<template>
    <div>{{ props.state ? 'Выполненный' : 'В работе' }}</div>
</template>
