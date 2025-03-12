<script setup>
import { ref } from 'vue';
import DatePicker from './datePicker.vue';
const props = defineProps({
    labelText: String,
    placeholder: String,
    staticWidth: Boolean,
});
let showDrop = ref(false);
</script>

<template>
    <div class="z-0 h-10 w-full">
        <div class="z-0" :class="props.staticWidth ? 'w-[364px]' : 'w-full'">
            <p class="mb-1.5 text-sm text-gray-900">{{ props.labelText }}</p>
            <button
                @click="showDrop = !showDrop"
                type="button"
                class="h-fit rounded-lg border-[1px] border-gray-300 bg-gray-50 px-4 py-3.5 text-left text-base text-gray-500"
                :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
            >
                {{ props.placeholder }}
            </button>
        </div>
        <div>
            <DatePicker v-if="showDrop" class="mt-1.5"></DatePicker>
        </div>
    </div>
</template>
