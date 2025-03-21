<script setup>
import BreadWay from '@/Components/breadWay.vue';
import { ref } from 'vue';
import { onMounted } from 'vue';
import Header from '@/Components/header.vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
import IconButton from '@/Components/iconButton.vue';
import EntranceList from '@/Components/entranceList.vue';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import CustomUniversalTable from '@/Components/tables/customUniversalTable.vue';
import ContactBlock from '@/Components/adressesBlocks/contactBlock.vue';
import DocumentsData from '@/Components/documentsData.vue';
import ObjectPhotoBLock from '@/Components/objectPhotoBLock.vue';
import Montazh from '@/Layouts/montazh.vue';
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
            :hrefStart="'/' + contractNumber + '/' + adressId"
            :id="adressId"
            :entrances="data != null ? data.entranceCount : ''"
        ></EntranceList>
        <p class="mb-3 mt-10 text-2xl text-gray-900">Дом</p>
        <RoundedArrowLineDropdown text="Данные" class="mb-10"
            ><CustomUniversalTable
                :readonly-fields="[true, false, false]"
                :speciall-data="{ adressId: adressId }"
                delete-command="deleteBuildingData"
                special-getters="building"
                :head-items="[
                    'Наименование',
                    'Значение',
                    'Примечание',
                    'Действия',
                ]"
                :last-action="true"
            ></CustomUniversalTable>
        </RoundedArrowLineDropdown>
        <ContactBlock :id="adressId"></ContactBlock>
        <DocumentsData
            where-fetch="/getDocuments"
            table-name="adressDocument"
            :id="adressId"
            text="Документы"
        ></DocumentsData>
        <DocumentsData
            where-fetch="/getEED"
            table-name="EED"
            :id="adressId"
            text="ИД"
        ></DocumentsData>
        <ObjectPhotoBLock :id="adressId"></ObjectPhotoBLock>
        <Montazh></Montazh>
    </div>
</template>
