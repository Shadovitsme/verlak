<script setup lang="ts">
import JustButton from './justButton.vue';
const props = defineProps({
    submitButtonText: String,
});
</script>

<template>
    <div
        class="relative m-auto h-fit w-fit rounded-3xl bg-white p-10 shadow-md"
    >
        <img class="absolute right-4 top-4" src="/assets/icons/system/x.svg" />
        <form><slot> </slot></form>

        <div class="mt-5 flex w-full justify-center gap-5">
            <JustButton class="w-full" color="dark">Отмена</JustButton>
            <JustButton class="w-full" color="blue">{{
                props.submitButtonText
            }}</JustButton>
        </div>
    </div>
</template>
