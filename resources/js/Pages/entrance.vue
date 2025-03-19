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
import OpenModal from '@/Components/openModal.vue';
import addElevator from '@/Components/jsFunctions/setters/addElevator';
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
        console.log(data.value.legth);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
let toggleModal = ref(false);
let currentToDelete = ref();
function deleteElevator(name) {
    currentToDelete.value = name;
    toggleModal.value = !toggleModal.value;
}
function closeModal() {
    currentToDelete.value = null;
    toggleModal.value = !toggleModal.value;
}
</script>

<template>
    <OpenModal
        @close="closeModal()"
        :toggleModal="toggleModal"
        modal-type="deleteElevator"
        :speciall-add-data="{
            name: currentToDelete,
            adressId: adressId,
            entrance: entranceName,
        }"
    ></OpenModal>
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
            @add-item="addElevator(data.length + 1, adressId, entranceName)"
        ></textHeadWithAddButton>
        <div v-for="(dat, index) in data" :key="dat">
            <RoundedArrowLineDropdown
                @delete="deleteElevator(index + 1)"
                :text="'Лифт ' + index"
            >
                <CustomUniversalTable
                    delete-command="deleteElevatorData"
                    :readonly-fields="[true, false, false, false]"
                    specialGetters="elevator"
                    :speciallData="dat"
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
