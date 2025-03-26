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
import CustomInput from '@/Components/customInput.vue';
import JustButton from '@/Components/justButton.vue';

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
function deleteElevator(name) {
    currentToDelete.value = name;
    toggleModal.value = !toggleModal.value;
}
function closeModal() {
    currentToDelete.value = null;
    toggleModal.value = !toggleModal.value;
}

const addItemVisible = ref([]); // Массив для отслеживания видимости по индексу
const newItem = ref('');

// Функция add теперь принимает индекс элемента
function add(index) {
    if (customUniversalTable.value[index]) {
        customUniversalTable.value[index].addLine(newItem.value);
        newItem.value = '';
        addItemVisible.value[index] = false;
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
                @add="addItemVisible[index] = true"
                class="mb-2"
                @delete="deleteElevator(index + 1)"
                :text="'Лифт ' + index"
            >
                <CustomUniversalTable
                    :ref="(el) => (customUniversalTable[index] = el)"
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
                <div
                    v-if="addItemVisible[index]"
                    class="mt-3 flex w-fit items-center gap-3"
                >
                    <CustomInput
                        :value="newItem"
                        :static-width="true"
                        @update:value="(newValue) => (newItem = newValue)"
                    ></CustomInput>
                    <JustButton
                        @click="addItemVisible[index] = false"
                        color="gray"
                        >Отмена</JustButton
                    >
                    <JustButton @click="add(index)" color="blue"
                        >Сохранить</JustButton
                    >
                </div>
            </RoundedArrowLineDropdown>
        </div>
        <ODSH :adress-id="adressId" :entrance="entranceName"></ODSH>
    </div>
</template>
