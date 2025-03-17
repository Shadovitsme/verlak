<script setup>
const props = defineProps(['text']);
const emit = defineEmits(['delete']);
</script>
<template>
    <div class="w-full rounded-lg bg-white px-4 py-2">
        <div class="flex h-full items-center justify-between py-2.5 pl-5">
            <div class="flex">
                <p class="mr-2 text-sm text-gray-800">{{ props.text }}</p>
                <img
                    class="size-5"
                    src="/assets/icons/arrows/arrow-right-1.svg"
                />
            </div>
            <img
                @click="emit('delete')"
                src="/assets/icons/system/delete.svg"
            />
        </div>
    </div>
</template>
