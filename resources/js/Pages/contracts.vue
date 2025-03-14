<script setup>
import CreateContractForm from '@/Layouts/createContractForm.vue';
import Header from '@/Components/header.vue';
import IconButton from '@/Components/iconButton.vue';
import { ref } from 'vue';
import TableWithStatus from '@/Components/tables/tableWithStatus.vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
let toggleCreateContract = ref(false);
let data = ref();
async function fetchData() {
    try {
        const result = await getExecData('/getExecContract', '54454');
        data.value = result;
        console.log(data.value);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
fetchData();
</script>

<template>
    <Header></Header>

    <div
        v-if="!toggleCreateContract"
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
        <div class="mb-5 flex gap-x-4" v-if="toggleCreateContract">
            <p
                @click="toggleCreateContract = !toggleCreateContract"
                class="my-auto text-sm text-gray-700 hover:underline"
            >
                Учёт договоров
            </p>
            <img class="size-5" src="/assets/icons/arrows/arrow-right-1.svg" />
            <p class="my-auto text-sm text-gray-700">Создание договора</p>
        </div></CreateContractForm
    >
</template>
