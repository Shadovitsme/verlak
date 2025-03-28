<script setup>
import checkStyle from './jsFunctions/buttonStyleArray';

const props = defineProps({
    color: String,
    selected: Boolean,
    src: String,
});

let style = checkStyle(props.color);
</script>
<template>
    <button
        type="button"
        :class="
            'h-fit rounded-lg px-5 py-2.5 text-sm ' +
            style +
            (props.selected ? 'text-indigo-700' : '')
        "
    >
        <img class="mr-2" :src="props.src" />
        <slot></slot>
    </button>
</template>
