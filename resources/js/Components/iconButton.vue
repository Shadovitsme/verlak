<script setup>
import checkStyle from './js functions/buttonStyleArray';

const props = defineProps({
    color: String,
    icon: String,
});
let colorStyle = checkStyle(props.color);
</script>
<template>
    <button :class="'flex size-11 rounded-full p-2.5 ' + colorStyle">
        <img class="m-auto" :src="props.icon" />
    </button>
</template>
