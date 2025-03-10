<script setup>
import EditDeleteComponent from './editDeleteComponent.vue';
import StatusLabel from './statusLabel.vue';
import { ref, onMounted } from 'vue';
import TableInpueElement from './tableInpueElement.vue';
import getDataForTableFill from './jsFunctions/getters/getDataForTableFill.js';
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

async function fetchData() {
    try {
        const result = await getDataForTableFill();
        data.value = result;
        calculateColumnWidths();
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function calculateColumnWidths() {
    const table = document.querySelector('table');
    const headers = table.querySelectorAll('th');
    const rows = table.querySelectorAll('tbody tr');

    columnWidths.value = Array.from(headers).map((header, colIndex) => {
        let maxWidth = header.offsetWidth;
        rows.forEach((row) => {
            const cell = row.children[colIndex];
            if (cell.offsetWidth > maxWidth) {
                maxWidth = cell.offsetWidth;
            }
        });
        return `${maxWidth}px`;
    });
}

onMounted(() => {
    fetchData();
});

function toggleChangableStatus(id) {
    readonlyFlag.value = id;
}
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
                :id="data[index][0] + index"
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
                    v-for="(field, indexElem) in data[index]"
                    :key="field"
                >
                    <TableInpueElement
                        :selected="selectedRow === dataItem"
                        :even="index % 2 !== 0"
                        :placeholder="props.placeholders[indexElem] || ''"
                        :readonly-state="
                            readonlyFlag != dataItem[0] + index
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
                        :key="index"
                        modalType="deleteManager"
                        @editable="toggleChangableStatus(dataItem[0] + index)"
                    />
                </td>
                <td v-if="props.lastStatus" class="px-4">
                    <StatusLabel :key="index" :state="true" />
                </td>
            </tr>
        </tbody>
    </table>
</template>
