<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted, defineExpose } from 'vue';
import addWorkerAdress from '../jsFunctions/setters/addWorkerAdress';

const props = defineProps({
    avansData: Object,
    adressData: Object,
});

const selectedRow = ref(undefined);
const selectedRowIndex = ref(undefined);
const target = ref(null);

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

// Преобразуем данные в нужный формат
const tableData = ref([]);
const computeTableData = () => {
    tableData.value = [];
    let avansIndex = 0;

    props.adressData?.forEach((address, addressIndex) => {
        let remainingAmount = address.fullPrice;
        let avansCount = Math.ceil(
            props.avansData.length / props.adressData.length,
        );

        // Добавляем первую строку с адресом и первым авансом
        if (props.avansData?.[avansIndex]) {
            remainingAmount -= props.avansData[avansIndex].value || 0;
            tableData.value.push({
                address: address.name,
                fullPrice: address.fullPrice,
                avans: props.avansData[avansIndex].value,
                date: props.avansData[avansIndex].date,
                comment: props.avansData[avansIndex].comment,
                remainingPercent: (
                    (remainingAmount / address.fullPrice) *
                    100
                ).toFixed(1),
                remainingAmount: remainingAmount,
                isFirstRow: true,
                id: address.id,
            });
            avansIndex++;

            // Добавляем остальные авансы для этого адреса
            while (
                avansIndex < props.avansData.length &&
                avansIndex < (addressIndex + 1) * avansCount
            ) {
                remainingAmount -= props.avansData[avansIndex].value || 0;
                tableData.value.push({
                    address: '',
                    fullPrice: '',
                    avans: props.avansData[avansIndex].value,
                    date: props.avansData[avansIndex].date,
                    comment: props.avansData[avansIndex].comment,
                    remainingPercent: (
                        (remainingAmount / address.fullPrice) *
                        100
                    ).toFixed(1),
                    remainingAmount: remainingAmount,
                    isFirstRow: false,
                    id: address.id,
                });
                avansIndex++;
            }
        }
    });
};

const handleBodyClick = (event) => {
    if (!target.value?.contains(event.target)) {
        selectedRow.value = undefined;
        selectedRowIndex.value = undefined;
    }
};

function addAdress(id, adress) {
    tableData.value.forEach((element) => {
        if (element.isFirstRow) {
            addWorkerAdress(
                id,
                adress,
                element.fullPrice,
                element.avans,
                element.comment,
                element.date,
            );
        }
    });
}

defineExpose({ addAdress });

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

    // Пересчитываем остатки при изменении значений
    if (indexItem === 1 || indexItem === 2) {
        let currentAddressId = row.id;
        let remainingAmount = tableData.value.find(
            (r) => r.id === currentAddressId && r.isFirstRow,
        ).fullPrice;

        tableData.value.forEach((r) => {
            if (r.id === currentAddressId) {
                if (r.avans) remainingAmount -= r.avans;
                r.remainingAmount = remainingAmount;
                r.remainingPercent =
                    ((remainingAmount / r.fullPrice) * 100).toFixed(1) ||
                    (
                        (remainingAmount /
                            tableData.value.find(
                                (r) =>
                                    r.id === currentAddressId && r.isFirstRow,
                            ).fullPrice) *
                        100
                    ).toFixed(1);
            }
        });
    }
}

onMounted(() => {
    computeTableData();
    document.addEventListener('click', handleBodyClick);
});

onUnmounted(() => {
    document.removeEventListener('click', handleBodyClick);
});
</script>

<template>
    <div class="w-full overflow-x-auto">
        <table
            id="table"
            @click="handleBodyClick"
            class="border-collapse rounded-lg shadow-sm"
            :class="
                props.scrollTable
                    ? 'min-w-max table-fixed'
                    : 'w-full table-auto'
            "
        >
            <thead class="rounded-lg bg-indigo-50 text-left text-gray-500">
                <tr class="h-12 rounded-lg">
                    <th
                        class="px-4 text-xs text-gray-500"
                        :class="props.scrollTable ? columnWidths[index] : ''"
                        v-for="(item, index) in headItems"
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
                    @click="selectedRow = trIndex"
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
                    <td class="px-4">
                        <input
                            :value="row.address"
                            @input="updateData(trIndex, 0, $event.target.value)"
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
                    <td class="px-4">
                        <input
                            :value="row.fullPrice"
                            @input="updateData(trIndex, 1, $event.target.value)"
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
                    <td class="px-4">
                        <input
                            :value="row.avans"
                            @input="updateData(trIndex, 2, $event.target.value)"
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
                    <td class="px-4">
                        <input
                            :value="row.date"
                            @input="updateData(trIndex, 3, $event.target.value)"
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
                    <td class="px-4">
                        <input
                            :value="row.comment"
                            @input="updateData(trIndex, 4, $event.target.value)"
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
                    <td class="px-4">
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
                    <td class="px-4">
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
                    <td class="px-4">
                        <EditDeleteComponent
                            :id-to-delete="row.id"
                            :modalType="props.modalType"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
