<script setup>
import { ref } from 'vue';
import DocumentlittleCard from './documentlittleCard.vue';
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
import OpenModal from './openModal.vue';
import { transliterate } from 'transliteration';
const props = defineProps({
    text: String,
    id: String,
});
let toggleModal = ref(false);
let folder = props.id + '/' + transliterate(props.text);
let tableName = 'adressDocument';
</script>

<template>
    <OpenModal
        :toggle-modal="toggleModal"
        @close="toggleModal = !toggleModal"
        :speciall-add-data="{
            folder: folder,
            fatherId: props.id,
            tableName: tableName,
        }"
        modal-type="addFile"
    ></OpenModal>
    <div class="mt-10">
        <TextHeadWithAddButton
            @add-item="toggleModal = !toggleModal"
            :text="props.text"
            :shown="true"
        >
        </TextHeadWithAddButton>
        <div class="mt-3 flex w-full gap-2">
            <DocumentlittleCard
                v-for="i in 5"
                text="test text.pdf"
                :key="i"
            ></DocumentlittleCard>
        </div>
    </div>
</template>
