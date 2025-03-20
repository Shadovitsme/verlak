<script setup>
const props = defineProps({
    text: String,
});
</script>
<template>
    <div class="shadow-xs flex w-fit gap-x-5 rounded-lg bg-white px-4 py-3">
        <p class="text-sm leading-tight text-gray-900">{{ props.text }}</p>
        <div class="flex h-4 gap-x-0.5">
            <img src="/assets/icons/system/download-file.svg" />
            <img src="/assets/icons/system/delete.svg" />
        </div>
    </div>
</template>
