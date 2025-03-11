<script setup>
import EditDeleteComponent from './editDeleteComponent.vue';
import StatusLabel from './statusLabel.vue';
import { ref, onMounted } from 'vue';
import TableInpueElement from './tableInpueElement.vue';
import getDataForTableFill from './jsFunctions/getters/getDataForTableFill.js';
import { watch } from 'vue';

const props = defineProps({
    headItems: Array,
    dataQuery: String,
    lastAction: Boolean,
    lastStatus: Boolean,
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
        const result = await getDataForTableFill();
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function toggleChangableStatus(id, index) {
    readonlyFlag.value = id;
    selectedRowIndex.value = Number(index);
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
                });
                return;
            }
            if (oldSelectedRowIndex == 0) {
                data.value[0].forEach((element, index) => {
                    if (index == 0) {
                        return;
                    }
                    checkUndefinedTableColumn(oldReadonlyFlag, index);
                    refillDataArray(0, index, id);
                });
                return;
            }
        }
    },
);

onMounted(() => {
    fetchData();
});
</script>

<template>
    <table class="w-full border-collapse shadow-sm">
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
        <tbody>
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
                    v-for="(field, indexElem) in data[index].slice(1)"
                    :key="field"
                >
                    <TableInpueElement
                        :selected="selectedRow === dataItem"
                        :even="index % 2 !== 0"
                        :placeholder="props.placeholders[indexElem] || ''"
                        :readonly-state="
                            readonlyFlag != dataItem[0]
                                ? true
                                : props.readonlyFields[indexElem]
                                  ? true
                                  : false
                        "
                        :value="field"
                    />
                </td>
                <td v-if="props.lastAction" class="px-4">
                    <EditDeleteComponent
                        :id-to-delete="data[index][0]"
                        :key="index"
                        modalType="deleteManager"
                        @editable="toggleChangableStatus(dataItem[0], index)"
                    />
                </td>
                <td v-if="props.lastStatus" class="px-4">
                    <StatusLabel :key="index" :state="true" />
                </td>
            </tr>
        </tbody>
    </table>
</template>
