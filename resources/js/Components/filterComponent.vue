<script setup lang="ts">
import DropdownCalendarButton from './dropdowns/dropdownCalendarButton.vue';
import DropdownInputButton from './dropdowns/dropdownInputButton.vue';
import DropdownStatusButton from './dropdowns/dropdownStatusButton.vue';
import town from './jsFunctions/town';
</script>

<template>
    <div class="flex w-337 justify-end">
        <div class="flex w-[1004px] gap-8">
            <DropdownCalendarButton
                placeholder="Выбрать дату"
            ></DropdownCalendarButton>
            <DropdownInputButton
                :static-width="false"
                placeholder="Выберите город"
                check-type="radio"
                :label-text-arr="town"
            >
            </DropdownInputButton>
            <DropdownInputButton
                :static-width="false"
                placeholder="Организация"
                check-type="radio"
                :label-text-arr="['ВЕРЕЛАК', 'ПСК']"
            ></DropdownInputButton>
            <DropdownStatusButton
                id="state"
                :static-width="false"
                placeholder="Выберите статус"
                check-type="radio"
                :label-text-arr="['В работе', 'Выполнено']"
            >
            </DropdownStatusButton>
        </div>
    </div>
</template>
