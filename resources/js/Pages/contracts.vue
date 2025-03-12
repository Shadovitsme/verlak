<script setup>
import CreateContractForm from '@/Components/createContractForm.vue';
// import CustomUniversalTable from '@/Components/customUniversalTable.vue';
import Header from '@/Components/header.vue';
import IconButton from '@/Components/iconButton.vue';
import { ref } from 'vue';
let toggleCreateContract = ref(false);
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
        <CustomUniversalTable
            :head-items="[
                'Номер договора',
                'Дата',
                'Город',
                'Организация',
                'Менеджер',
                'Статус',
            ]"
            :last-status="true"
        ></CustomUniversalTable>
    </div>

    <CreateContractForm v-if="toggleCreateContract"></CreateContractForm>
</template>
