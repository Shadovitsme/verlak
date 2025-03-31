<script setup>
import JustButton from './justButton.vue';
import IconButton from './iconButton.vue';
import goBack from './jsFunctions/goBack';

const props = defineProps({
    backLink: String,
    buttonText: String,
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
}
</script>

<template>
    <div class="mt-8 flex w-full justify-between">
        <JustButton
            @click="goBack(props.backLink)"
            color="blue"
            src="/assets/icons/arrows/arrow-left.svg"
            >{{ props.buttonText }}</JustButton
        >

        <IconButton
            icon="/assets/icons/arrows/arrow-up.svg"
            color="gray"
            @click="scrollToTop"
        ></IconButton>
    </div>
</template>
