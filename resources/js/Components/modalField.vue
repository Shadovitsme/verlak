<script setup lang="ts">
import JustButton from './justButton.vue';
const emit = defineEmits(['close', 'submit']);
const props = defineProps({
    submitButtonText: String,
});
</script>

<template>
    <div
        class="relative m-auto h-fit w-fit rounded-3xl bg-white p-10 shadow-md"
    >
        <img
            @click="emit('close')"
            class="absolute right-4 top-4"
            src="/assets/icons/system/x.svg"
        />
        <form @submit.prevent="emit('submit')">
            <slot></slot>
            <div class="mt-5 flex w-full justify-center gap-5">
                <JustButton @click="emit('close')" class="w-full" color="dark"
                    >Отмена</JustButton
                >
                <JustButton type="submit" class="w-full" color="blue">{{
                    props.submitButtonText
                }}</JustButton>
            </div>
        </form>
    </div>
</template>
