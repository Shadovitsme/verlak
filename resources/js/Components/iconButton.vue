<script setup>
import checkStyle from './jsFunctions/buttonStyleArray';

const props = defineProps({
    color: String,
    icon: String,
});
let colorStyle = checkStyle(props.color);
</script>
<template>
    <button :class="'flex size-11 rounded-full p-2.5 ' + colorStyle">
        <img
            :class="
                'm-auto ' +
                (props.color == 'blue' || props.color == 'dark' ? 'white' : '')
            "
            :src="props.icon"
        />
    </button>
</template>

<style scoped>
.white {
    filter: brightness(0) saturate(100%) invert(100%) sepia(0%) saturate(1443%)
        hue-rotate(290deg) brightness(113%) contrast(101%);
}
</style>
