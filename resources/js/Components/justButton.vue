<script setup>
import checkStyle from './js functions/buttonStyleArray';

const props = defineProps({
    color: String,
});

let style = checkStyle(props.color);
</script>
<template>
    <button :class="'rounded-lg px-5 py-2.5 text-sm ' + style">
        <slot></slot>
    </button>
</template>
