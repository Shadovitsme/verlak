<script setup>
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
import ImageItem from './imageItem.vue';
import OpenModal from './openModal.vue';
import { ref } from 'vue';
import { transliterate } from 'transliteration';
const props = defineProps({
    text: String,
    imageArray: Array,
    fatherId: String,
    adressId: String,
});
let toggleModal = ref(false);
let folder = props.adressId + '/' + transliterate(props.text);
</script>

<template>
    <OpenModal
        :toggle-modal="toggleModal"
        @close="toggleModal = !toggleModal"
        :speciall-add-data="{
            folder: folder,
            fatherId: props.fatherId,
            tableName: 'adressPhoto',
        }"
        modal-type="addFile"
    ></OpenModal>
    <div class="mb-3 w-full rounded-lg bg-white p-5">
        <TextHeadWithAddButton
            :shown="true"
            :text="props.text"
            @add-item="toggleModal = !toggleModal"
        ></TextHeadWithAddButton>
        <div
            v-if="props.imageArray.length != 0"
            class="mt-5 flex flex-wrap gap-5"
        >
            <ImageItem
                v-for="item in props.imageArray"
                :key="item"
                :src="'/' + item"
            ></ImageItem>
        </div>
    </div>
</template>
