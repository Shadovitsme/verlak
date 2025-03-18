<script setup>
import { ref } from 'vue';
import JustButton from './justButton.vue';
const props = defineProps(['text', 'href']);
const emit = defineEmits(['delete']);
let openDropDown = ref(false);
</script>
<template>
    <div
        @click="openDropDown = !openDropDown"
        class="w-full rounded-lg bg-white px-4 py-2"
    >
        <div class="flex h-full items-center justify-between py-2.5 pl-5">
            <div :href="props.href" class="flex">
                <p class="mr-2 text-sm text-gray-800">{{ props.text }}</p>
                <img
                    class="size-5"
                    :src="
                        '/assets/icons/arrows/arrow-' +
                        (openDropDown ? 'up' : 'down') +
                        '-1.svg'
                    "
                />
            </div>
            <img
                @click="emit('delete')"
                src="/assets/icons/system/delete.svg"
            />
        </div>
        <div class="mt-3" v-if="openDropDown">
            <slot></slot>
            <div class="mt-3 flex w-full justify-end">
                <JustButton color="blue">Добавить наименование</JustButton>
            </div>
        </div>
    </div>
</template>
