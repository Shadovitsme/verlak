<script setup lang="ts">
import StatusLabel from './statusLabel.vue';
import IconButton from './iconButton.vue';
import CustomUniversalTable from './tables/customUniversalTable.vue';
import OpenModal from './openModal.vue';
import { ref } from 'vue';
const props = defineProps({
    contractNumber: String,
    headItems: Array,
    data: Object,
    managerName: String,
});
let openModal = ref(false);
const emit = defineEmits(['editContract']);
const dbAdressColumnNames = [
    'adminDistrict',
    'townDistrict',
    'adress',
    'elevatorCount',
    'entrance',
    'buildingSerial',
    'projectType',
    'dateStart',
    'dateEnd',
    'price',
];
</script>

<template>
    <OpenModal
        @close="openModal = !openModal"
        modal-type="deleteContract"
        :id-to-delete="props.data != null ? props.data.id : ''"
        :toggle-modal="openModal"
    ></OpenModal>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <slot></slot>

        <div class="flex w-full justify-between">
            <div>
                <p class="mb-3 text-4xl text-gray-900">
                    {{ 'Договор №' + props.contractNumber }}
                </p>
                <p class="mb-3 text-gray-700">
                    {{ 'Сотрудник: ' + props.managerName }}
                    <!-- TODO заменить на сотрудника который это дело и создал -->
                </p>
                <StatusLabel
                    class="mb-6"
                    :state="
                        props.data && props.data.state != null
                            ? props.data.state == 'В работе'
                            : false
                    "
                ></StatusLabel>
            </div>
            <div class="flex h-11 gap-x-3">
                <IconButton
                    @click="emit('editContract')"
                    color="gray"
                    icon="/assets/icons/system/edit.svg"
                ></IconButton>
                <IconButton
                    @click="openModal = !openModal"
                    color="gray"
                    icon="/assets/icons/system/delete.svg"
                ></IconButton>
            </div>
        </div>

        <div class="mb-5 flex h-fit content-center items-center">
            <p class="my-auto mr-4 text-2xl text-gray-900">Адреса</p>
        </div>
        <CustomUniversalTable
            :scrollWidth="true"
            deleteCommand="deleteAdress"
            :column-queue="dbAdressColumnNames"
            api="/getAdressesforContract"
            :exec="true"
            :search-foreign-key="props.contractNumber"
            :placeholders="[
                'Название округа',
                'Название района',
                'Адрес ',
                'n',
                '№',
                '№',
                'Наименование типа',
                'дд.мм.гггг',
                'дд.мм.гггг',
                'Сумма',
            ]"
            :last-action="true"
            :head-items="props.headItems"
        ></CustomUniversalTable>
    </div>
</template>
