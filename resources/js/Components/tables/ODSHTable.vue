<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted, defineExpose } from 'vue';
import addWorkerAdress from '../jsFunctions/setters/addWorkerAdress';
import addAvanceForAdress from '../jsFunctions/setters/addAvanceForAdress';
import JustButton from '../justButton.vue';

const props = defineProps({
    avansData: Array,
    adressData: Object,
});

const selectedRow = ref(undefined);
const selectedRowIndex = ref(undefined);
const target = ref(null);
const newAvances = ref([]); // Массив для хранения новых несохранённых строк

let headItems = [
    'Адрес',
    'Общая стоимость, ₽ ',
    'Авансы, ₽ ',
    'Дата',
    'Примечание',
    'Остаток, %',
    'Остаток, ₽',
    'Действия',
];
let placeholders = ['Сумма', 'Сумма', 'дд.мм.гггг', 'Комментарий', '-', '-'];

const tableData = ref([]);
const computeTableData = () => {
    tableData.value = [];
    let remainingAmount = props.adressData.fullPrice || 0;

    // Добавляем строки из props.avansData
    if (props.avansData?.length > 0) {
        props.avansData.forEach((avans, index) => {
            const avansValue = avans.value || 0;
            remainingAmount -= avansValue;
            tableData.value.push({
                address: index === 0 ? props.adressData.name : '',
                fullPrice: index === 0 ? props.adressData.fullPrice : '',
                avans: avansValue,
                date: avans.date || '',
                comment: avans.comment || '',
                remainingPercent: props.adressData.fullPrice
                    ? (
                          (remainingAmount / props.adressData.fullPrice) *
                          100
                      ).toFixed(1)
                    : '0.0',
                remainingAmount: remainingAmount,
                isFirstRow: index === 0,
                id: props.adressData.id,
                avanceId: avans.id || null,
            });
        });
    } else {
        tableData.value.push({
            address: props.adressData.name,
            fullPrice: props.adressData.fullPrice,
            avans: 0,
            date: '',
            comment: '',
            remainingPercent: '100.0',
            remainingAmount: props.adressData.fullPrice,
            isFirstRow: true,
            id: props.adressData.id,
            avanceId: null,
        });
    }

    // Добавляем новые несохранённые строки
    newAvances.value.forEach((newAvance) => {
        remainingAmount -= newAvance.avans || 0;
        tableData.value.push({
            ...newAvance,
            remainingPercent: props.adressData.fullPrice
                ? (
                      (remainingAmount / props.adressData.fullPrice) *
                      100
                  ).toFixed(1)
                : '0.0',
            remainingAmount: remainingAmount,
        });
    });
};

const handleBodyClick = async (event) => {
    if (
        !target.value?.contains(event.target) &&
        selectedRow.value !== undefined
    ) {
        const row = tableData.value[selectedRow.value];
        if (row) {
            try {
                const response = await addAvanceForAdress(
                    row.avanceId || false,
                    row.id,
                    row.comment,
                    row.avans,
                    row.date,
                );
                if (!row.avanceId && response?.id) {
                    row.avanceId = response.id;
                    // Удаляем строку из newAvances после сохранения
                    newAvances.value = newAvances.value.filter(
                        (avance) => avance !== row,
                    );
                }
                computeTableData(); // Пересчитываем остатки
            } catch (error) {
                console.error('Failed to save avance:', error);
                computeTableData(); // Пересчитываем остатки даже при ошибке
            }
        }
        selectedRow.value = undefined;
        selectedRowIndex.value = undefined;
    }
};

function addAdress(id, adress) {
    const firstRow = tableData.value[0];
    addWorkerAdress(
        id,
        adress,
        firstRow.fullPrice,
        firstRow.avans,
        firstRow.comment,
        firstRow.date,
    );
}

const addNewAvance = () => {
    const newRow = {
        address: '',
        fullPrice: '',
        avans: 0,
        date: '',
        comment: '',
        remainingPercent: '',
        remainingAmount: '',
        isFirstRow: false,
        id: props.adressData.id,
        avanceId: null,
    };
    newAvances.value.push(newRow);
    computeTableData(); // Пересчитываем таблицу с учетом новой строки
};

function updateData(trIndex, indexItem, value) {
    let row = tableData.value[trIndex];

    if (indexItem === 0 && row.isFirstRow) {
        row.address = value;
    } else if (indexItem === 1 && row.isFirstRow) {
        row.fullPrice = parseFloat(value) || 0;
    } else if (indexItem === 2) {
        row.avans = parseFloat(value) || 0;
    } else if (indexItem === 3) row.date = value;
    else if (indexItem === 4) row.comment = value;

    if (indexItem === 1 || indexItem === 2) {
        let remainingAmount = tableData.value[0].fullPrice || 0;
        tableData.value.forEach((r) => {
            if (r.avans) remainingAmount -= r.avans;
            r.remainingAmount = remainingAmount;
            r.remainingPercent = r.fullPrice
                ? ((remainingAmount / r.fullPrice) * 100).toFixed(1)
                : (
                      (remainingAmount / tableData.value[0].fullPrice) *
                      100
                  ).toFixed(1);
        });
    }
}

defineExpose({ addAdress });

onMounted(() => {
    computeTableData();
    document.addEventListener('click', handleBodyClick);
});

onUnmounted(() => {
    document.removeEventListener('click', handleBodyClick);
});
</script>

<template>
    <div class="w-full">
        <div class="overflow-x-auto">
            <table
                id="table"
                @click="handleBodyClick"
                class="w-full table-auto border-collapse rounded-lg shadow-sm"
            >
                <thead class="rounded-lg bg-indigo-50 text-left text-gray-500">
                    <tr class="h-12 rounded-lg">
                        <th
                            class="px-4 text-xs text-gray-500"
                            v-for="item in headItems"
                            :key="item"
                        >
                            {{ item }}
                        </th>
                    </tr>
                </thead>
                <tbody ref="target" @click.stop>
                    <tr
                        v-for="(row, trIndex) in tableData"
                        :id="headItems[0] + String(trIndex)"
                        :class="[
                            'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100',
                            selectedRow === trIndex
                                ? 'bg-indigo-100'
                                : trIndex % 2 !== 0
                                  ? 'bg-gray-50'
                                  : 'bg-white',
                        ]"
                        :key="trIndex"
                    >
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.address"
                                @input="
                                    updateData(trIndex, 0, $event.target.value)
                                "
                                :readonly="!row.isFirstRow"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                placeholder="Адрес"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.fullPrice"
                                @input="
                                    updateData(trIndex, 1, $event.target.value)
                                "
                                :readonly="!row.isFirstRow"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                :placeholder="placeholders[0]"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.avans"
                                @input="
                                    updateData(trIndex, 2, $event.target.value)
                                "
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                :placeholder="placeholders[1]"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.date"
                                @input="
                                    updateData(trIndex, 3, $event.target.value)
                                "
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                :placeholder="placeholders[2]"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.comment"
                                @input="
                                    updateData(trIndex, 4, $event.target.value)
                                "
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                :placeholder="placeholders[3]"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.remainingPercent"
                                readonly
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                :placeholder="placeholders[4]"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <input
                                :value="row.remainingAmount"
                                readonly
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    selectedRow === trIndex
                                        ? 'bg-indigo-100'
                                        : trIndex % 2 !== 0
                                          ? 'bg-gray-50'
                                          : 'bg-white',
                                ]"
                                :placeholder="placeholders[5]"
                            />
                        </td>
                        <td class="px-4" @click="selectedRow = trIndex">
                            <EditDeleteComponent
                                modal-type="deleteAvans"
                                :id-to-delete="row.avanceId"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex w-full justify-end">
            <JustButton @click="addNewAvance" color="blue">
                Добавить выплату
            </JustButton>
        </div>
    </div>
</template>
