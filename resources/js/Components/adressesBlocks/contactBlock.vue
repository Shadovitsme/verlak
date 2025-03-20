<script setup>
import { onMounted, ref } from 'vue';
import RoundedArrowLineDropdown from '../roundedArrowLineDropdown.vue';
import TextHeadWithAddButton from '../textHeadWithAddButton.vue';
import EmptyTable from '../tables/emptyTable.vue';
import LineSaveEntrance from '../lineSaveEntrance.vue';
import getExecData from '../jsFunctions/getters/getExecData';
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
        rowCounter.value.push(element.length != undefined ? element.length : 1);
    });
}
onMounted(() => {
    fetchData();
});
</script>

<template>
    <TextHeadWithAddButton
        :shown="true"
        text="Контакты"
        @add-item="showAdd = !showAdd"
    ></TextHeadWithAddButton>
    <RoundedArrowLineDropdown
        @add="rowCounter[index] = rowCounter[index] + 1"
        class="mb-3"
        v-for="(elem, index) in data"
        :text="elem.name"
        :key="elem"
        ><EmptyTable
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
