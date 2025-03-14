<script setup>
import CreateContractForm from '@/Layouts/createContractForm.vue';
import Header from '@/Components/header.vue';
import IconButton from '@/Components/iconButton.vue';
import { ref } from 'vue';
import TableWithStatus from '@/Components/tables/tableWithStatus.vue';
import BreadWay from '@/Components/breadWay.vue';
import ExecContractData from '@/Components/execContractData.vue';
let toggleCreateContract = ref(false);
let toggleOneContract = ref(false);
let selectedContractNumber = ref();

const handleRowClick = (event) => {
    selectedContractNumber.value = event;
    toggleOneContract.value = true;
    toggleCreateContract.value = false;
};
</script>

<template>
    <Header></Header>

    <div
        v-if="!toggleCreateContract && !toggleOneContract"
        class="mx-32 mt-20 min-w-full max-w-[1600px] pt-12"
    >
        <div class="mb-8 flex">
            <h1 class="my-auto mr-4 text-5xl text-gray-900">Учёт договоров</h1>
            <IconButton
                @click="toggleCreateContract = !toggleCreateContract"
                class="my-auto rotate-45"
                color="blue"
                icon="/assets/icons/system/x.svg"
            ></IconButton>
        </div>
        <TableWithStatus
            @row-click="handleRowClick"
            api="/getContracts"
            :head-items="[
                'Номер договора',
                'Дата',
                'Город',
                'Организация',
                'Менеджер',
                'Статус',
            ]"
            :last-status="true"
        ></TableWithStatus>
    </div>

    <CreateContractForm
        @close="toggleCreateContract = !toggleCreateContract"
        v-if="toggleCreateContract"
    >
        <BreadWay
            @goto-main="toggleCreateContract = !toggleCreateContract"
            start-point-text="Учёт договоров"
            current-point-text="Создание договора"
        ></BreadWay>
    </CreateContractForm>
    <ExecContractData :id="selectedContractNumber" v-if="toggleOneContract">
        <BreadWay
            @goto-main="toggleOneContract = !toggleOneContract"
            start-point-text="Учёт договоров"
            :current-point-text="'Договор №' + selectedContractNumber"
        ></BreadWay
    ></ExecContractData>
</template>
