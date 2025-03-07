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
            :data-filler="[
                ['a', 'd', '3', '5', 'dfd', true],
                ['a', 'd', '3', '5', 'dfd', false],
            ]"
            :last-status="true"
        ></CustomUniversalTable
    ></PagePlace>
</template>
