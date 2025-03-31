<script setup>
import CreateContractForm from '@/Layouts/createContractForm.vue';
import Header from '@/Components/header.vue';
import IconButton from '@/Components/iconButton.vue';
import { ref } from 'vue';
import TableWithStatus from '@/Components/tables/tableWithStatus.vue';
import BreadWay from '@/Components/breadWay.vue';
import ExecContractData from '@/Components/execContractData.vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
import gotocontracts from '@/Components/jsFunctions/goToContract';
import FilterComponent from '@/Components/filterComponent.vue';
import JustButton from '@/Components/justButton.vue';
let toggleCreateContract = ref(false);
let toggleOneContract = ref(false);
let selectedContractNumber = ref(null);
let editContract = ref(false);
const filterShow = ref(false);

const { contractNumber } = defineProps(['contractNumber']);

contractNumber != undefined ? fetchData() : '';

const handleRowClick = (event) => {
    selectedContractNumber.value = event;
    toggleOneContract.value = true;
    toggleCreateContract.value = false;
    fetchData();
};

let data = ref(null);
async function fetchData() {
    if (contractNumber != undefined) {
        selectedContractNumber.value = contractNumber;
        toggleOneContract.value = true;
    }
    try {
        const result = await getExecData(
            '/getExecContract',
            selectedContractNumber.value,
        );
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function close() {
    toggleCreateContract.value = false;
    toggleOneContract.value = false;
    editContract.value = false;
    selectedContractNumber.value = undefined;
}

const filters = ref({
    city: '',
    organization: [],
    state: [],
});

function test(filterData) {
    filters.value = filterData;
}
</script>

<template>
    <Header></Header>

    <div
        v-if="!toggleCreateContract && !toggleOneContract"
        class="mx-32 mt-20 min-w-full max-w-[1600px] pt-12"
    >
        <div
            :class="filterShow ? 'mb-3' : 'mb-6'"
            class="flex w-337 items-center justify-between"
        >
            <div class="flex">
                <h1 class="my-auto mr-4 text-5xl text-gray-900">
                    Учёт договоров
                </h1>
                <IconButton
                    @click="toggleCreateContract = !toggleCreateContract"
                    class="my-auto rotate-45"
                    color="blue"
                    icon="/assets/icons/system/x.svg"
                ></IconButton>
            </div>
            <JustButton
                @click="filterShow = !filterShow"
                class="flex align-middle"
                color="noColor"
                ><p class="my-auto">Фильтровать</p>
                <img
                    class="imgColorlessButton my-auto ml-2 inline-block size-5"
                    src="/assets/icons/arrows/arrow-down-1.svg"
                />
            </JustButton>
        </div>
        <FilterComponent
            @change-filter="test"
            v-if="filterShow"
        ></FilterComponent>

        <TableWithStatus
            :filters="filters"
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
        @close="close()"
        v-if="toggleCreateContract || editContract"
        :contractNumber="selectedContractNumber"
        :data="data"
    >
        <BreadWay
            @goto-main="contractNumber != undefined ? gotocontracts() : close()"
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
            'Стоимость <br /> (с НДС 20%),₽',
            'Действия',
        ]"
        :data="data"
        :manager-name="data.manager"
        :contractNumber="selectedContractNumber"
        v-if="toggleOneContract && !editContract"
    >
        <BreadWay
            @goto-main="contractNumber != undefined ? gotocontracts() : close()"
            start-point-text="Учёт договоров"
            :current-point-text="'Договор №' + selectedContractNumber"
        ></BreadWay
    ></ExecContractData>
</template>
