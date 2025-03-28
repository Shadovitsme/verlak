<script setup>
import BreadWay from '@/Components/breadWay.vue';
import { ref } from 'vue';
import { onMounted } from 'vue';
import Header from '@/Components/header.vue';
import getExecEntrance from '@/Components/jsFunctions/getters/getExecEntrance';
import textHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import CustomUniversalTable from '@/Components/tables/customUniversalTable.vue';
import OpenModal from '@/Components/openModal.vue';
import addElevator from '@/Components/jsFunctions/setters/addElevator';
import ODSH from '@/Layouts/ODSH.vue';

let data = ref(null);
let customUniversalTable = ref([]); // Теперь массив для хранения всех таблиц
const { contractNumber, adressId, entranceName } = defineProps([
    'contractNumber',
    'adressId',
    'entranceName',
]);

onMounted(() => {
    fetchData(adressId);
});

async function fetchData(adressId) {
    try {
        const result = await getExecEntrance(adressId, entranceName);
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

let toggleModal = ref(false);
let currentToDelete = ref();
function deleteElevator(dat) {
    currentToDelete.value = dat.name;
    toggleModal.value = !toggleModal.value;
}
function closeModal() {
    currentToDelete.value = null;
    toggleModal.value = !toggleModal.value;
}

const addItemVisible = ref([]); // Массив для отслеживания видимости по индексу

// Функция add теперь принимает индекс элемента
function add(index) {
    if (customUniversalTable.value[index]) {
        customUniversalTable.value[index].addLine('');
    } else {
        console.error(`Таблица с индексом ${index} не найдена`);
    }
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
        <div class="mt-3" v-for="(dat, index) in data" :key="dat">
            <RoundedArrowLineDropdown
                :hide-button="addItemVisible[index]"
                @add="add(index)"
                class="mb-2"
                @delete="deleteElevator(dat)"
                :text="'Лифт ' + (index + 1)"
            >
                <CustomUniversalTable
                    :scroll-width="false"
                    :ref="(el) => (customUniversalTable[index] = el)"
                    delete-command="deleteElevatorData"
                    :readonly-fields="[]"
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
        <ODSH :adress-id="adressId" :entrance="entranceName"></ODSH>
    </div>
</template>
