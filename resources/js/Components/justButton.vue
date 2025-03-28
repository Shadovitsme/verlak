<script setup>
import checkStyle from './jsFunctions/buttonStyleArray';

const props = defineProps({
    color: String,
    selected: Boolean,
    src: { type: String, default: () => '' },
});

let style = checkStyle(props.color);
</script>
<template>
    <button
        class="h-fit rounded-lg px-5 py-2.5 text-sm"
        type="button"
        :class="[
            style + (props.selected ? 'text-indigo-700' : ''),
            props.src != '' ? 'flex gap-2' : '',
        ]"
    >
        <img
            v-if="props.src != ''"
            class="size-5"
            :src="props.src"
            style="
                filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg)
                    brightness(100%) contrast(100%);
            "
        />
        <slot></slot>
    </button>
</template>
