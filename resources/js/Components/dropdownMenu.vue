<script setup>
const props = defineProps({
    labelTextArr: Array,
});
</script>
<template>
    <div
        class="overflow-y-auto overflow-x-hidden rounded-lg bg-white p-1 shadow-sm"
    >
        <div :key="text" v-for="text in props.labelTextArr">
            <input
                :name="props.labelTextArr[0]"
                :id="text"
                type="radio"
            /><label :for="text">{{ text }}</label>
        </div>
    </div>
</template>
