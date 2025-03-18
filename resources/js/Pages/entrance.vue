<script setup>
import BreadWay from '@/Components/breadWay.vue';
import { ref } from 'vue';
import { onMounted } from 'vue';
import Header from '@/Components/header.vue';
import getExecEntrance from '@/Components/jsFunctions/getters/getExecEntrance';
// import elevatorDefaultArray from '@/Components/jsFunctions/elevatorDefaultArray';
import textHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import CustomUniversalTable from '@/Components/tables/customUniversalTable.vue';
let data = ref(null);

// Объявляем пропсы
const { contractNumber, adressId, entranceName } = defineProps([
    'contractNumber',
    'adressId',
    'entranceName',
]); // Пример использования
onMounted(() => {
    fetchData(adressId);
    console.log(entranceName);
});

// const defaultElevatorTableNamesArray = elevatorDefaultArray;

async function fetchData(adressId) {
    try {
        const result = await getExecEntrance(adressId, entranceName);
        data.value = result;
        console.log(data.value);
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
        <p class="mb-8 text-4xl text-gray-900">
            {{ 'Подъезд ' + entranceName }}
        </p>
        <textHeadWithAddButton
            :shown="true"
            text="Лифты"
        ></textHeadWithAddButton>
        <div v-for="(dat, index) in data" :key="dat">
            <RoundedArrowLineDropdown :text="'Лифт ' + index">
                <CustomUniversalTable
                    delete-command="deleteElevatorData"
                    :readonly-fields="[true, false, false, false]"
                    specialGetters="elevator"
                    :elevator-data="dat"
                    :lastAction="true"
                    :head-items="[
                        'Наименование',
                        'Значение',
                        'Примечание',
                        'Действие',
                    ]"
                ></CustomUniversalTable>
            </RoundedArrowLineDropdown>
        </div>
    </div>
</template>
