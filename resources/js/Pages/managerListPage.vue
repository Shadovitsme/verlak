<template>
    <PagePlace page-name="Список сотрудников">
        <TablePlaceholder
            :lastAction="true"
            :head-items="['ФИО', 'email', 'phone', 'pass', 'action']"
            :readonly-fields="[true, false, false, true, true]"
            dataQuery="getAllManagers"
        ></TablePlaceholder>
    </PagePlace>
</template>

<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import TablePlaceholder from '@/Components/customUniversalTable.vue';
</script>
