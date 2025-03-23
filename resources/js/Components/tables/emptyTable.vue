<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted, defineExpose } from 'vue';
import addWorkerAdress from '../jsFunctions/setters/addWorkerAdress';
import addAvanceForAdress from '../jsFunctions/setters/addAvanceForAdress';

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

const tableData = ref([]);
const computeTableData = () => {
    tableData.value = [];
    let avansIndex = 0;

    props.adressData?.forEach((address, addressIndex) => {
        let remainingAmount = address.fullPrice || 0;
        let avansPerAddress = props.avansData
            ? Math.ceil(props.avansData.length / props.adressData.length)
            : 0;

        // Добавляем первую строку адреса
        if (props.avansData?.[avansIndex]) {
            remainingAmount -= props.avansData[avansIndex].value || 0;
            tableData.value.push({
                address: address.name,
                fullPrice: address.fullPrice,
                avans: props.avansData[avansIndex].value || 0,
                date: props.avansData[avansIndex].date || '',
                comment: props.avansData[avansIndex].comment || '',
                remainingPercent: address.fullPrice
                    ? ((remainingAmount / address.fullPrice) * 100).toFixed(1)
                    : '0.0',
                remainingAmount: remainingAmount,
                isFirstRow: true,
                id: address.id,
                avanceId: props.avansData[avansIndex].id || null, // Предполагаю, что у avansData есть id
            });
            avansIndex++;

            // Добавляем остальные авансы для этого адреса
            while (
                avansIndex < props.avansData?.length &&
                avansIndex < (addressIndex + 1) * avansPerAddress
            ) {
                remainingAmount -= props.avansData[avansIndex].value || 0;
                tableData.value.push({
                    address: '',
                    fullPrice: '',
                    avans: props.avansData[avansIndex].value || 0,
                    date: props.avansData[avansIndex].date || '',
                    comment: props.avansData[avansIndex].comment || '',
                    remainingPercent: address.fullPrice
                        ? ((remainingAmount / address.fullPrice) * 100).toFixed(
                              1,
                          )
                        : '0.0',
                    remainingAmount: remainingAmount,
                    isFirstRow: false,
                    id: address.id,
                    avanceId: props.avansData[avansIndex].id || null,
                });
                avansIndex++;
            }
        } else {
            // Если авансов нет, добавляем только адрес
            tableData.value.push({
                address: address.name,
                fullPrice: address.fullPrice,
                avans: 0,
                date: '',
                comment: '',
                remainingPercent: '100.0',
                remainingAmount: address.fullPrice,
                isFirstRow: true,
                id: address.id,
                avanceId: null,
            });
        }

        // Всегда добавляем строку с кнопкой после последнего аванса или адреса
        tableData.value.push({
            isAddButton: true,
            id: address.id,
            address: '',
            fullPrice: '',
            avans: 0,
            date: '',
            comment: '',
            remainingPercent: '',
            remainingAmount: '',
        });
    });
};

const handleBodyClick = async (event) => {
    if (
        !target.value?.contains(event.target) &&
        selectedRow.value !== undefined
    ) {
        const row = tableData.value[selectedRow.value];
        if (row && !row.isAddButton) {
            const response = await addAvanceForAdress(
                row.avanceId || false,
                row.id,
                row.comment,
                row.avans,
                row.date,
            );
            if (!row.avanceId && response?.id) {
                row.avanceId = response.id;
            }
            computeTableData(); // Пересчитываем остатки
        }
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

const addNewAvance = (addressId) => {
    const insertIndex = tableData.value.findIndex(
        (row) => row.isAddButton && row.id === addressId,
    );

    tableData.value.splice(insertIndex, 0, {
        address: '',
        fullPrice: '',
        avans: 0,
        date: '',
        comment: '',
        remainingPercent: '',
        remainingAmount: '',
        isFirstRow: false,
        id: addressId,
        avanceId: null,
    });
    computeTableData(); // Пересчитываем остатки
};

function updateData(trIndex, indexItem, value) {
    let row = tableData.value[trIndex];
    if (row.isAddButton) return;

    if (indexItem === 0 && row.isFirstRow) {
        row.address = value;
    } else if (indexItem === 1 && row.isFirstRow) {
        row.fullPrice = parseFloat(value) || 0;
    } else if (indexItem === 2) {
        row.avans = parseFloat(value) || 0;
    } else if (indexItem === 3) row.date = value;
    else if (indexItem === 4) row.comment = value;

    if (indexItem === 1 || indexItem === 2) {
        let currentAddressId = row.id;
        let remainingAmount =
            tableData.value.find(
                (r) => r.id === currentAddressId && r.isFirstRow,
            ).fullPrice || 0;

        tableData.value.forEach((r) => {
            if (r.id === currentAddressId && !r.isAddButton) {
                if (r.avans) remainingAmount -= r.avans;
                r.remainingAmount = remainingAmount;
                r.remainingPercent = r.fullPrice
                    ? ((remainingAmount / r.fullPrice) * 100).toFixed(1)
                    : (
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
                    :class="[
                        'group h-14 border-y-[1px] border-gray-200',
                        !row.isAddButton ? 'hover:bg-indigo-100' : '',
                        selectedRow === trIndex
                            ? 'bg-indigo-100'
                            : trIndex % 2 !== 0
                              ? 'bg-gray-50'
                              : 'bg-white',
                    ]"
                    :key="trIndex"
                >
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                    <td
                        class="px-4"
                        @click="
                            !row.isAddButton ? (selectedRow = trIndex) : null
                        "
                    >
                        <input
                            v-if="!row.isAddButton"
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
                        <div
                            v-if="!row.isAddButton"
                            @click="selectedRow = trIndex"
                        >
                            <EditDeleteComponent
                                :id-to-delete="row.id"
                                :modalType="props.modalType"
                            />
                        </div>
                        <button
                            v-if="row.isAddButton"
                            @click="addNewAvance(row.id)"
                            class="rounded bg-indigo-500 px-4 py-2 text-white hover:bg-indigo-600"
                        >
                            Добавить выплату
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
