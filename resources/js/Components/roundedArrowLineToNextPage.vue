<script setup>
const props = defineProps(['text']);
</script>
<template>
    <div class="w-full rounded-lg bg-white px-4 py-2">
        <div class="flex h-full items-center justify-between px-5 py-2.5">
            <div class="flex">
                <p class="mr-2 text-sm text-gray-800">{{ props.text }}</p>
                <img
                    class="size-5"
                    src="/assets/icons/arrows/arrow-right-1.svg"
                />
            </div>
            <img src="/assets/icons/system/delete.svg" />
        </div>
    </div>
</template>
