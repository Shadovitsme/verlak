<script setup lang="ts">
import DropdownInputButton from '@/Components/dropdowns/dropdownInputButton.vue';
import PagePlace from '@/Components/pagePlace.vue';
</script>

<template>
    <PagePlace pageName="Исполнители">
        <DropdownInputButton
            :static-width="true"
            label-text="Город"
            placeholder="Выберите город"
            check-type="radio"
            :label-text-arr="['Астрахань', 'Москва', 'Санкт-Петербург']"
        ></DropdownInputButton>
    </PagePlace>
</template>
