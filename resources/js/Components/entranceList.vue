<script setup>
import LineSaveEntrance from './lineSaveEntrance.vue';
import OpenModal from './openModal.vue';
import RoundedArrowLineToNextPage from './roundedArrowLineToNextPage.vue';
import textHeadWithAddButton from './textHeadWithAddButton.vue';
import { ref } from 'vue';
const props = defineProps(['entrances', 'id', 'hrefStart']);
let showAdd = ref(false);
let showModal = ref(false);
let deleteId = ref(null);

function deleteAction(entranceName) {
    showModal.value = !showModal.value;
    deleteId.value = entranceName;
}
</script>
<template>
    <OpenModal
        :id-to-delete="deleteId"
        modal-type="deleteEntrance"
        :toggle-modal="showModal"
        @close="showModal = !showModal"
    ></OpenModal>
    <textHeadWithAddButton
        :shown="true"
        text="Подъезды"
        @click="showAdd = !showAdd"
    ></textHeadWithAddButton>
    <div class="space-y-3">
        <RoundedArrowLineToNextPage
            :href="props.hrefStart + '/' + item.entrance"
            @delete="deleteAction(item.entrance)"
            v-for="item in props.entrances"
            :text="'Подъезд ' + item.entrance"
            :key="item"
        ></RoundedArrowLineToNextPage>
        <LineSaveEntrance
            place="entrance"
            :id="props.id"
            @close="showAdd = !showAdd"
            v-if="showAdd"
        ></LineSaveEntrance>
    </div>
</template>
