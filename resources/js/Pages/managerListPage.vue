<template>
    <PagePlace add-modal-type="addManager" page-name="Список сотрудников">
        <TablePlaceholder
            api="/user"
            :lastAction="true"
            :head-items="['ФИО', 'email', 'phone', 'pass', 'action']"
            :readonly-fields="[false, false, false, false, false]"
            dataQuery="getAllManagers"
        ></TablePlaceholder>
    </PagePlace>
</template>

<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import TablePlaceholder from '@/Components/tables/customUniversalTable.vue';
</script>
