<template>
    <PagePlace add-modal-type="addManager" page-name="Список сотрудников">
        <TablePlaceholder
        class="w-[1348px]"
            deleteCommand="deleteManager"
            :exec="false"
            api="/user"
            :lastAction="true"
            :head-items="['ФИО', 'email', 'phone', 'pass', 'action']"
            :readonly-fields="[]"
            dataQuery="getAllManagers"
        ></TablePlaceholder>
    </PagePlace>
</template>

<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import TablePlaceholder from '@/Components/tables/customUniversalTable.vue';
</script>
