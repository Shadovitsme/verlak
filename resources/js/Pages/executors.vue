<script setup lang="ts">
import CustomUniversalTable from '@/Components/tables/customUniversalTable.vue';
import PagePlace from '@/Components/pagePlace.vue';
</script>

<template>
    <PagePlace pageName="Учёт договоров">
        <CustomUniversalTable
            :head-items="[
                'Номер договора',
                'Дата',
                'Город',
                'Организация',
                'Менеджер',
                'Статус',
            ]"
        ></CustomUniversalTable>
    </PagePlace>
</template>
