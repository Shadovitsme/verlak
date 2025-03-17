<script setup>
import LineSaveEntrance from './lineSaveEntrance.vue';
import OpenModal from './openModal.vue';
import RoundedArrowLineToNextPage from './roundedArrowLineToNextPage.vue';
import textHeadWithAddButton from './textHeadWithAddButton.vue';
import { ref } from 'vue';
const props = defineProps(['itemsCount', 'id']);
console.log(props.itemsCount);
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
        head-text="Подъезды"
        @click="showAdd = !showAdd"
    ></textHeadWithAddButton>
    <div class="space-y-3">
        <RoundedArrowLineToNextPage
            @delete="deleteAction(item.entrance)"
            v-for="item in props.itemsCount"
            :text="'Подъезд ' + item.entrance"
            :key="item"
        ></RoundedArrowLineToNextPage>
        <LineSaveEntrance
            :id="props.id"
            @close="showAdd = !showAdd"
            v-if="showAdd"
        ></LineSaveEntrance>
    </div>
</template>
