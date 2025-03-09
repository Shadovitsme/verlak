<template>
    <PagePlace page-name="Список сотрудников">
        <TablePlaceholder
            :lastAction="true"
            :head-items="['ФИО', 'email', 'phone', 'pass', 'action']"
            :readonly-fields="[1, 0, 0, 0, 0]"
            :dataQuery="[
                [
                    'Иванов Иван Михайлович',
                    'ivdsfaanov@mail.ru',
                    '+7 (900) 000-00fdsad-00',
                    '•••••••••',
                ],
                [
                    'Иванов fd Иван Михайлович',
                    'ivanov@mail.ru',
                    '+7 (900) 000-00-00',
                    '••••••dsf•••',
                ],
            ]"
        ></TablePlaceholder>
    </PagePlace>
</template>

<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import TablePlaceholder from '@/Components/customUniversalTable.vue';
</script>
