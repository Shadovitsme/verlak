<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted, defineExpose } from 'vue';
import addWorkerAdress from '../jsFunctions/setters/addWorkerAdress';

const props = defineProps({
    adressData: Object,
    avansData: Object,
});

const selectedRow = ref(undefined);
const selectedRowIndex = ref(undefined);
const target = ref(null);

let headItems = [
    'Общая стоимость, ₽ ',
    'Авансы, ₽ ',
    'Дата',
    'Примечание',
    'Остаток, %',
    'Остаток, ₽',
    'Действия',
];
let placeholders = ['Сумма', 'Сумма', 'дд.мм.гггг', 'Комментарий', '-', '-'];

const handleBodyClick = (event) => {
    if (!target.value?.contains(event.target)) {
        selectedRow.value = undefined;
        selectedRowIndex.value = undefined;
    }
};

function addAdress(id, adress) {
    data.value.forEach((element) => {
        console.log(element);
        addWorkerAdress(
            id,
            adress,
            element.summ,
            element.avans,
            element.comment,
            element.date,
        );
    });
}

defineExpose({ addAdress });

// Обновление данных при вводе
function updateData(trIndex, indexItem, value) {
    if (!data.value[trIndex]) {
        data.value[trIndex] = {};
    }

    if (indexItem === 0) data.value[trIndex].summ = value;
    else if (indexItem === 1) data.value[trIndex].avans = value;
    else if (indexItem === 2) data.value[trIndex].date = value;
    else if (indexItem === 3) data.value[trIndex].comment = value;
}

function chooseValue(trIndex, indexItem) {
    if (props.avansData?.[trIndex]) {
        const val = props.avansData[trIndex];

        return [val.summ, val.avans, val.date, val.comment][indexItem] || '';
    }
    return '';
}

onMounted(() => {
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
                    v-for="(count, trIndex) in props.avansData"
                    :id="headItems[0] + String(count)"
                    @click="selectedRow = count"
                    :class="[
                        'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100',
                        selectedRow === count
                            ? 'bg-indigo-100'
                            : count % 2 !== 0
                              ? 'bg-gray-50'
                              : 'bg-white',
                    ]"
                    :key="count"
                >
                    <td
                        class="px-4"
                        v-for="(item, index) in headItems.slice(1)"
                        :key="item"
                    >
                        <input
                            :value="chooseValue(trIndex, index)"
                            @input="
                                updateData(trIndex, index, $event.target.value)
                            "
                            :readonly="
                                props.allChangable
                                    ? props.modalType == 'deleteWorkerAdress'
                                        ? index == 4 || index == 5
                                        : false
                                    : index == 3 || index == 4
                            "
                            :class="[
                                'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                selectedRow === count
                                    ? 'bg-indigo-100'
                                    : count % 2 !== 0
                                      ? 'bg-gray-50'
                                      : 'bg-white',
                            ]"
                            :placeholder="placeholders[index]"
                        />
                    </td>
                    <td class="px-4">
                        <EditDeleteComponent
                            :id-to-delete="adressData?.[trIndex]?.id || 0"
                            :modalType="props.modalType"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
