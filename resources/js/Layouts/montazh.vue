<script setup>
import EmptyTable from '@/Components/tables/emptyTable.vue';
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import { ref } from 'vue';
let rowCounter = ref(1);

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
            v-if="rowCounter > 0"
            :head-items="['ФИО', 'Телефон', 'Примечание', 'Действия']"
            :row-counter="rowCounter"
            :all-changable="true"
            modal-type="deleteMontazh"
            :add-data="{adressId:props.id}"
        ></EmptyTable>
    </div>
</template>
