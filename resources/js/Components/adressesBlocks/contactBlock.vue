<script setup>
import { onMounted, ref } from 'vue';
import RoundedArrowLineDropdown from '../roundedArrowLineDropdown.vue';
import TextHeadWithAddButton from '../textHeadWithAddButton.vue';
import EmptyTable from '../tables/emptyTable.vue';
import LineSaveEntrance from '../lineSaveEntrance.vue';
import getExecData from '../jsFunctions/getters/getExecData';
import OpenModal from '../openModal.vue';
let showAdd = ref(false);
const data = ref();
const rowCounter = ref([]);
const props = defineProps({
    contractGroupData: Array,
    id: String,
});

async function fetchData() {
    const result = await getExecData('/getContactListData', props.id);
    data.value = result;
    data.value.forEach((element) => {
        rowCounter.value.push(
            element.personsCount == 0 ? 1 : element.personsCount,
        );
    });
}
onMounted(() => {
    fetchData();
});

const toggleModal = ref(false);
const idToDelete = ref();

function openDelete(id) {
    toggleModal.value = !toggleModal.value;
    idToDelete.value = id;
}
function closeDelete() {
    toggleModal.value = !toggleModal.value;
    idToDelete.value = unde;
}
</script>

<template>
    <OpenModal
        :toggle-modal="toggleModal"
        :id-to-delete="idToDelete"
        modal-type="deleteContactListItem"
        @close="closeDelete()"
    ></OpenModal>
    <TextHeadWithAddButton
        :shown="true"
        text="Контакты"
        @add-item="showAdd = !showAdd"
    ></TextHeadWithAddButton>
    <RoundedArrowLineDropdown
        @add="rowCounter[index] = rowCounter[index] + 1"
        @delete="openDelete(elem.id)"
        class="mb-3"
        v-for="(elem, index) in data"
        :text="elem.name"
        :key="elem"
        ><EmptyTable
            :scroll-table="false"
            modalType="deleteContact"
            :add-data="{ groupId: elem.id }"
            :all-changable="true"
            :last-action="true"
            :row-counter="rowCounter[index]"
            :placeholders="[]"
            :head-items="[
                'ФИО контактного лица',
                'Должность',
                'Телефон',
                'Адрес',
                'Действия',
            ]"
        ></EmptyTable>
    </RoundedArrowLineDropdown>
    <LineSaveEntrance
        place="contact"
        :id="props.id"
        @close="showAdd = !showAdd"
        v-if="showAdd"
    ></LineSaveEntrance>
</template>
