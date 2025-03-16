<script setup>
import CreateContractForm from '@/Layouts/createContractForm.vue';
import Header from '@/Components/header.vue';
import IconButton from '@/Components/iconButton.vue';
import { ref } from 'vue';
import TableWithStatus from '@/Components/tables/tableWithStatus.vue';
import BreadWay from '@/Components/breadWay.vue';
import ExecContractData from '@/Components/execContractData.vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
let toggleCreateContract = ref(false);
let toggleOneContract = ref(false);
let selectedContractNumber = ref(null);
let editContract = ref(false);

const handleRowClick = (event) => {
    selectedContractNumber.value = event;
    toggleOneContract.value = true;
    toggleCreateContract.value = false;
    fetchData();
};

let data = ref(null);
async function fetchData() {
    try {
        const result = await getExecData(
            '/getExecContract',
            selectedContractNumber.value,
        );
        data.value = result;
        console.log(data.value.state);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
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
        v-if="toggleCreateContract || editContract"
        :contractNumber="selectedContractNumber"
        :data="data"
    >
        <BreadWay
            @goto-main="toggleCreateContract = !toggleCreateContract"
            start-point-text="Учёт договоров"
            :middle-point-text="
                editContract ? 'Договор №' + selectedContractNumber : ''
            "
            @goto-middle="editContract = false"
            :current-point-text="
                toggleCreateContract
                    ? 'Создание договора'
                    : 'Изменение договора'
            "
        ></BreadWay>
    </CreateContractForm>
    <ExecContractData
        @edit-contract="editContract = true"
        :headItems="[
            'Административный округ',
            'Район',
            'Адрес многоквартирного дома ',
            'Кол-во лифтов',
            'Подъезд',
            'Серия дома',
            'Тип проекта',
            'Дата начала',
            'Дата окончания',
            'Стоимость(с НДС 20%),₽',
            'Действия',
        ]"
        :data="data"
        :contractNumber="selectedContractNumber"
        v-if="toggleOneContract && !editContract"
    >
        <BreadWay
            @goto-main="toggleOneContract = !toggleOneContract"
            start-point-text="Учёт договоров"
            :current-point-text="'Договор №' + selectedContractNumber"
        ></BreadWay
    ></ExecContractData>
</template>
