<script setup>
import Header from './header.vue';
import { ref } from 'vue';
import IconButton from './iconButton.vue';
import OpenModal from './openModal.vue';
const props = defineProps({
    pageName: String,
    addModalType: String,
});
let toggleModal = ref(false);
</script>

<template>
    <OpenModal
        :toggle-modal="toggleModal"
        @close="toggleModal = !toggleModal"
        :modal-type="props.addModalType"
    ></OpenModal>
    <Header></Header>
    <div class="mx-32 mt-20 w-full max-w-[1600px] pt-12">
        <div class="mb-8 flex">
            <h1 class="my-auto mr-4 text-5xl text-gray-900">
                {{ props.pageName }}
            </h1>
            <IconButton
                @click="toggleModal = !toggleModal"
                class="my-auto rotate-45"
                color="blue"
                icon="/assets/icons/system/x.svg"
            ></IconButton>
        </div>
        <slot></slot>
    </div>
</template>
