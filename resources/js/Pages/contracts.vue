<script setup lang="ts">
import PagePlace from '@/Components/pagePlace.vue';
import CustomUniversalTable from '@/Components/customUniversalTable.vue';
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
            :last-status="true"
        ></CustomUniversalTable
    ></PagePlace>
</template>
