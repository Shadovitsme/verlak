<script setup>
const props = defineProps({
    selected: Boolean,
    even: Boolean,
    readonlyState: Boolean,
    placeholder: String,
    value: String,
});
</script>

<template>
    <input
        :class="
            'h-full w-full border-none bg-none px-4 placeholder:text-gray-400 group-hover:bg-indigo-100 ' +
            (props.selected
                ? 'bg-indigo-100'
                : props.even
                  ? 'bg-gray-50'
                  : 'bg-white') +
            ' ' +
            (props.readonlyState ? 'text-gray-900' : 'text-gray-500')
        "
        :placeholder="props.placeholder"
        :readonly="props.readonlyState"
        :value="props.value"
    />
</template>
