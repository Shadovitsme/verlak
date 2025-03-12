<script setup>
import checkStyle from './jsFunctions/buttonStyleArray';

const props = defineProps({
    color: String,
    selected: Boolean,
});

let style = checkStyle(props.color);
</script>
<template>
    <button
        type="button"
        :class="
            'rounded-lg px-5 py-2.5 text-sm ' +
            style +
            (props.selected ? 'text-indigo-700' : '')
        "
    >
        <slot></slot>
    </button>
</template>
