<script setup lang="ts">
import CustomInput from '@/Components/customInput.vue';
import IconButton from '@/Components/iconButton.vue';
import JustButton from '@/Components/justButton.vue';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import ODSHTable from '@/Components/tables/ODSHTable.vue';
import { ref } from 'vue';

const props = defineProps({
    customerProps: { type: String, default: () => '' },
    Adress: { type: String, default: () => '' },
    Manager: { type: String, default: () => '' },
    Phone: { type: String, default: () => '' },
    SizeProps: { type: String, default: () => '' },
    ODSHTableData: { type: Object, default: () => ({}) },
});

const editMode = ref(false);
const customer = ref(props.customerProps);
const size = ref(props.SizeProps);
</script>

<template>
    <div class="mt-8">
        <div class="flex w-full justify-between">
            <div>
                <div class="mb-5 flex items-center gap-4">
                    <p class="text-2xl text-gray-900">ОДШ</p>
                    <IconButton
                        @click="editMode = true"
                        color="blue"
                        icon="/assets/icons/system/edit.svg"
                    ></IconButton>
                </div>
                <p v-if="!editMode" class="text-gray-700">
                    {{ 'Заказчик: ' + customer }}
                </p>
                <CustomInput
                    :value="customer"
                    v-if="editMode"
                    :static-width="true"
                    label-text="Заказчик"
                    @update:value="(newValue) => (customer = newValue)"
                ></CustomInput>
                <p class="text-gray-700">{{ 'Адресс: ' + props.Adress }}</p>
                <p class="text-gray-700">{{ 'Сотрудник: ' + props.Manager }}</p>
                <p class="text-gray-700">{{ 'Телефон: ' + props.Phone }}</p>
                <CustomInput
                    :value="size"
                    v-if="editMode"
                    :static-width="true"
                    label-text="Размер"
                    @update:value="(newValue) => (size = newValue)"
                ></CustomInput>
                <p v-if="!editMode" class="mt-10 text-gray-700">
                    {{ 'Размер С: ' + size }}
                </p>
                <JustButton
                    v-if="editMode"
                    @click="editMode = false"
                    color="blue"
                    >Сохранить</JustButton
                >
            </div>
            <img class="shrink-0" src="/assets/pictures/lifti project 2.png" />
        </div>
        <RoundedArrowLineDropdown text="Таблица">
            <ODSHTable :-o-d-s-h-table-data="props.ODSHTableData"></ODSHTable>
        </RoundedArrowLineDropdown>
    </div>
</template>
