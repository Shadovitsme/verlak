<script setup>
import StatusLabel from '../statusLabel.vue';
import { ref, onMounted } from 'vue';
import TableInpueElement from '../tableInpueElement.vue';
import getDataForTableFill from '../jsFunctions/getters/getDataForTableFill.js';
import { watch } from 'vue';

const props = defineProps({
    headItems: Array,
    dataQuery: String,
    lastAction: Boolean,
    lastStatus: Boolean,
    api: String,
    readonlyFields: { type: Array, default: () => [] },
    placeholders: { type: Array, default: () => [] },
});

let data = ref([]);
const columnWidths = ref([]);
let readonlyFlag = ref('');
let selectedRow = ref(null);
let selectedRowIndex = ref();

async function fetchData() {
    try {
        const result = await getDataForTableFill(props.api);
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function checkUndefinedTableColumn(oldReadonlyFlag, index) {
    if (
        document.getElementById(oldReadonlyFlag).getElementsByTagName('input')[
            index - 1
        ] == undefined
    ) {
        return 1;
    }
}

function refillDataArray(selectedRowIndex, columtIndex, id) {
    data.value[selectedRowIndex][columtIndex] = document
        .getElementById(id)
        .getElementsByTagName('input')[columtIndex - 1].value;
}

watch(
    [readonlyFlag, selectedRowIndex],
    (
        [newReadonlyFlag, newSelectedRowIndex],
        [oldReadonlyFlag, oldSelectedRowIndex],
    ) => {
        if (
            newReadonlyFlag !== oldReadonlyFlag ||
            newSelectedRowIndex !== oldSelectedRowIndex
        ) {
            let id = data.value[0][0];

            if (oldSelectedRowIndex != undefined && oldSelectedRowIndex > 0) {
                data.value[oldSelectedRowIndex].forEach((element, index) => {
                    if (index == 0) {
                        return;
                    }
                    checkUndefinedTableColumn(oldReadonlyFlag, index);
                    refillDataArray(
                        oldSelectedRowIndex,
                        index,
                        oldReadonlyFlag,
                    );
                    updateManagerData(
                        id,
                        data.value[oldSelectedRowIndex][1],
                        data.value[oldSelectedRowIndex][2],
                        data.value[oldSelectedRowIndex][3],
                        data.value[oldSelectedRowIndex][4],
                    );
                    return;
                });
            }
            if (oldSelectedRowIndex == 0) {
                data.value[0].forEach((element, index) => {
                    if (index == 0) {
                        return;
                    }
                    checkUndefinedTableColumn(oldReadonlyFlag, index);
                    refillDataArray(0, index, id);
                    updateManagerData(
                        id,
                        data.value[0][1],
                        data.value[0][2],
                        data.value[0][3],
                        data.value[0][4],
                    );
                });
                return;
            }
        }
    },
);

onMounted(() => {
    fetchData();
});
const target = ref(null);
const handleBodyClick = (event) => {
    if (target.value || !target.value.contains(event.target)) {
        readonlyFlag.value = undefined;
        selectedRow.value = undefined;
        selectedRowIndex.value = undefined;
    }
};

// Добавляем и убираем слушатель через onMounted/onUnmounted
import { onUnmounted } from 'vue';
import updateManagerData from '../jsFunctions/setters/updateManagerData';
onMounted(() => {
    document.addEventListener('click', handleBodyClick);
});
onUnmounted(() => {
    document.removeEventListener('click', handleBodyClick);
});
</script>

<template>
    <table
        @click="handleBodyClick"
        class="table-auto border-collapse rounded-lg shadow-sm"
    >
        <thead class="bg-indigo-50 text-left text-gray-500">
            <tr class="h-12">
                <th
                    class="px-4"
                    v-for="item in props.headItems"
                    :style="{ width: columnWidths[index] }"
                    :key="item"
                >
                    {{ item }}
                </th>
            </tr>
        </thead>
        <tbody ref="target" @click.stop>
            <tr
                :id="data[index][0]"
                @click="selectedRow = dataItem"
                :class="[
                    'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100',
                    selectedRow === dataItem
                        ? 'bg-indigo-100'
                        : index % 2 !== 0
                          ? 'bg-gray-50'
                          : 'bg-white',
                ]"
                v-for="(dataItem, index) in data"
                :key="index"
            >
                <td
                    class="px-4"
                    v-for="field in data[index].slice(1, -1)"
                    :key="field"
                >
                    <TableInpueElement
                        :selected="selectedRow === dataItem"
                        :even="index % 2 !== 0"
                        :readonly-state="true"
                        :value="field"
                    />
                </td>
                <td class="px-4">
                    <StatusLabel
                        :key="index"
                        :state="
                            data[index][data[index].length - 1] == 'В работе'
                        "
                    />
                </td>
            </tr>
        </tbody>
    </table>
</template>
