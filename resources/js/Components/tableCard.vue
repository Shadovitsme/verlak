<script setup>
import { ref } from 'vue';
import TablePlaceholder from './tablePlaceholder.vue';

const props = defineProps({
    head: String,
});

let toggleTable = ref(false);
</script>
<template>
    <div class="mx-32 h-fit rounded-lg bg-white px-4 py-2">
        <div class="flex justify-between">
            <button @click="toggleTable = !toggleTable" class="flex px-5">
                <p class="my-auto mr-2 text-sm text-gray-800">
                    {{ props.head }}
                </p>
                <img
                    class="size-5"
                    src="/assets/icons/arrows/arrow-right-1.svg"
                />
            </button>
            <img src="/assets/icons/system/delete.svg" />
        </div>
        <TablePlaceholder v-if="toggleTable"></TablePlaceholder>
    </div>
</template>
