<script setup>
import EmptyTable from '@/Components/tables/emptyTable.vue';
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import { ref, onMounted } from 'vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
let rowCounter = ref(0);
let data = ref();
async function fetchData() {
    let result;

    result = await getExecData(
        '/universalGetter',
        props.id,
        'adressId',
        'montazh',
    );
    data.value = result;
    rowCounter.value = data.value.length;
}

onMounted(() => {
    fetchData();
});
const props = defineProps({
    id: String,
});
</script>

<template>
    <div class="mt-10">
        <TextHeadWithAddButton
            @add-item="rowCounter++"
            :shown="true"
            class="mb-3"
            text="Монтажники"
        ></TextHeadWithAddButton>
        <EmptyTable
            :scroll-table="false"
            v-if="rowCounter > 0"
            :head-items="['ФИО', 'Телефон', 'Примечание', 'Действия']"
            :row-counter="rowCounter"
            :all-changable="true"
            modal-type="deleteMontazh"
            :add-data="{ adressId: props.id }"
        ></EmptyTable>
    </div>
</template>
