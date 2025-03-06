<script setup>
const props = defineProps({
    color: String,
});
let colorArray = [
    ' bg-gray-200 hover:bg-gray-300 active:bg-gray-300 text-gray-800 ',
    ' bg-gray-800 hover:bg-gray-700 disabled:bg-gray-600 text-white disabled:text-gray-500 ',
    ' bg-indigo-700 hover:bg-indigo-800 text-white  ',
    ' text-gray-800 hover:text-indigo-700 ',
];
let style;
switch (props.color) {
    case 'gray':
        style = colorArray[0];
        break;
    case 'dark':
        style = colorArray[1];
        break;
    case 'blue':
        style = colorArray[2];
        break;
    case 'noColor':
        style = colorArray[3];
        break;
    default:
        break;
}
</script>
<template>
    <button :class="'rounded-lg px-5 py-2.5 text-sm ' + style">
        <slot></slot>
    </button>
</template>
