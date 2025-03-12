<script setup>
const props = defineProps({
    state: Boolean,
});
</script>
<template>
    <div
        class="w-36 justify-center rounded-md py-0.5 text-xs"
        :class="
            props.state
                ? 'bg-emerald-100 text-emerald-700'
                : 'bg-indigo-200 text-indigo-700'
        "
    >
        {{ props.state ? 'Выполненный' : 'В работе' }}
    </div>
</template>
