<script setup>
import { ref } from 'vue';
import StatusLabel from '../statusLabel.vue';

const props = defineProps({
    labelText: String,
    placeholder: String,
    staticWidth: Boolean,
    labelTextArr: Array,
    checkType: String,
    value: String,
});
let showDrop = ref(false);
let content = ref(props.value ? props.value : props.placeholder);
function checked(id) {
    content.value = id;
    showDrop.value = false;
}
</script>

<template>
    <div class="z-10 h-12 w-full">
        <div class="" :class="props.staticWidth ? 'w-[364px]' : 'w-full'">
            <p class="mb-1.5 text-sm text-gray-900">{{ props.labelText }}</p>
            <button
                @click="showDrop = !showDrop"
                type="button"
                class="h-12 rounded-lg border-[1px] border-gray-300 bg-gray-50 px-4 text-left text-base text-gray-500"
                :class="props.staticWidth ? 'w-[364px]' : 'w-full'"
            >
                <p v-if="content == 'Выберите статус'">{{ content }}</p>
                <StatusLabel
                    v-if="content != 'Выберите статус'"
                    :state="content == 'В работе'"
                ></StatusLabel>
            </button>
        </div>
        <div
            v-if="showDrop"
            class="z-10 mt-1.5 h-fit max-h-40 w-full space-y-3 overflow-y-auto overflow-x-visible rounded-lg bg-white p-4 shadow-sm"
        >
            <div :key="text" v-for="text in props.labelTextArr">
                <input
                    @change="checked(text)"
                    :hidden="props.checkType == 'none'"
                    class="mr-2"
                    :name="props.labelTextArr[0]"
                    :id="text"
                    :type="props.checkType"
                /><label class="text-sm text-gray-900" :for="text">{{
                    text
                }}</label>
            </div>
        </div>
    </div>
</template>
