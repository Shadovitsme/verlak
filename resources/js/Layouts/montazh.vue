<script setup>
import EmptyTable from '@/Components/tables/emptyTable.vue';
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
</script>

<template>
    <div class="mt-10">
        <TextHeadWithAddButton
            :shown="true"
            class="mb-3"
            text="Монтажники"
        ></TextHeadWithAddButton>
        <EmptyTable
            :head-items="['ФИО', 'Телефон', 'Примечание', 'Действия']"
            :row-counter="1"
        ></EmptyTable>
    </div>
</template>
