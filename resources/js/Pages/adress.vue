<script setup>
import BreadWay from '@/Components/breadWay.vue';
import { ref } from 'vue';
import { onMounted } from 'vue';
import Header from '@/Components/header.vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
import IconButton from '@/Components/iconButton.vue';
import EntranceList from '@/Components/entranceList.vue';
let data = ref(null);

// Объявляем пропсы
const { contractNumber, adressId } = defineProps([
    'contractNumber',
    'adressId',
]); // Пример использования
onMounted(() => {
    fetchData(adressId);
});

async function fetchData(adressId) {
    try {
        const result = await getExecData('/getCurrentAdressData', adressId);
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
</script>

<template>
    <Header></Header>
    <div class="mx-32 mt-20 w-[1348px] max-w-[1600px] pt-12">
        <BreadWay
            start-point-text="Учёт договоров"
            :middle-point-text="'Договор №' + contractNumber"
            :current-point-text="data != null ? data.adress : ''"
        ></BreadWay>
        <div class="mb-6 flex w-full justify-between">
            <h1 class="my-auto mr-4 text-5xl text-gray-900">
                {{ data != null ? data.adress : '' }}
            </h1>
            <IconButton
                icon="/assets/icons/system/delete.svg"
                color="gray"
            ></IconButton>
        </div>
        <EntranceList
            :id="adressId"
            :items-count="data != null ? data.entranceCount : ''"
        ></EntranceList>
    </div>
</template>
