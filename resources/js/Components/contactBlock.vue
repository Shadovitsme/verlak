<script setup>
import RoundedArrowLineDropdown from './roundedArrowLineDropdown.vue';
import CustomUniversalTable from './tables/customUniversalTable.vue';
import TextHeadWithAddButton from './textHeadWithAddButton.vue';

const props = defineProps({
    contractGroupData: Array,
});
</script>

<template>
    <TextHeadWithAddButton
        :shown="true"
        text="Контакты"
    ></TextHeadWithAddButton>
    <RoundedArrowLineDropdown
        v-for="elem in props.contractGroupData"
        :text="elem"
        :key="elem"
        ><CustomUniversalTable
            :last-action="true"
            :head-items="[
                'ФИО контактного лица',
                'Должность',
                'Телефон',
                'Адрес',
                'Действия',
            ]"
        ></CustomUniversalTable>
    </RoundedArrowLineDropdown>
</template>
