<script setup>
import { ref, watch } from 'vue';
import DropdownCalendarButton from './dropdowns/dropdownCalendarButton.vue';
import DropdownCheckBox from './dropdowns/dropdownCheckBox.vue';
import DropdownInputButton from './dropdowns/dropdownInputButton.vue';
import town from './jsFunctions/town';

const city = ref('');
const organization = ref([]);
const state = ref([]);
const date = ref();

const emit = defineEmits(['changeFilter']);

watch(
    [date, city, organization, state],
    ([newDate, newCity, newOrganization, newState]) => {
        emit('changeFilter', {
            date: newDate,
            city: newCity,
            organization: newOrganization,
            state: newState,
        });
    },
);
</script>

<template>
    <div class="mb-6 flex w-337 justify-end">
        <div class="flex w-[1004px] gap-8">
            <DropdownCalendarButton
                :value="date"
                placeholder="Выбрать дату"
                @update:value="(newValue) => (date = newValue)"
            ></DropdownCalendarButton>
            <DropdownInputButton
                :value="city"
                :static-width="true"
                placeholder="Выберите город"
                check-type="radio"
                :label-text-arr="town"
                @update:value="(newValue) => (city = newValue)"
            >
            </DropdownInputButton>
            <DropdownCheckBox
                :value="organization"
                placeholder="Организация"
                :label-text-arr="['ВЕРЕЛАК', 'ПСК']"
                :static-width="false"
                @update:value="(newValue) => (organization = newValue)"
            ></DropdownCheckBox>
            <DropdownCheckBox
                :value="state"
                :static-width="false"
                placeholder="Статус"
                :label-text-arr="['В работе', 'Выполненный']"
                @update:value="(newValue) => (state = newValue)"
            ></DropdownCheckBox>
        </div>
    </div>
</template>
