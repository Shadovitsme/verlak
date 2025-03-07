<template>
    <Header></Header>
    <div class="mt-20 w-full max-w-[1600px]">
        <div class="flex">
            <h1 class="mr-4 text-5xl text-gray-900">{{ props.pageName }}</h1>
            <IconButton
                class="rotate-45"
                color="blue"
                icon="/assets/icons/system/x.svg"
            ></IconButton>
        </div>
    </div>
</template>
<script setup>
import Header from './header.vue';
import IconButton from './iconButton.vue';
const props = defineProps({
    pageName: String,
});
</script>
