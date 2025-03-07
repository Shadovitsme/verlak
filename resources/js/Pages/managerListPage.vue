<template>
    <PagePlace page-name="Список сотрудников">
        <TablePlaceholder
            :lastAction="true"
            :head-items="['ФИО', 'email', 'phone', 'pass', 'action']"
            :data-filler="[
                [
                    'Иванов Иван Михайлович',
                    'ivanov@mail.ru',
                    '+7 (900) 000-00-00',
                    '•••••••••',
                ],
                [
                    'Иванов Иван Михайлович',
                    'ivanov@mail.ru',
                    '+7 (900) 000-00-00',
                    '•••••••••',
                ],
            ]"
        ></TablePlaceholder>
    </PagePlace>
</template>

<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import TablePlaceholder from '@/Components/tablePlaceholder.vue';
</script>
