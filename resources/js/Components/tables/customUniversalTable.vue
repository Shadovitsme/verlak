<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import StatusLabel from '../statusLabel.vue';
import { ref, onMounted, watch, onUnmounted } from 'vue';
import TableInpueElement from '../tableInpueElement.vue';
import getDataForTableFill from '../jsFunctions/getters/getDataForTableFill.js';
import defaultHouseArray from '../jsFunctions/default data array/defaultHouseArray';
import updateManagerData from '../jsFunctions/setters/updateManagerData';
import getExecData from '../jsFunctions/getters/getExecData';
import elevatorFillerForUniversalTable from '../jsFunctions/getters/elevatorFillerForUniversalTable';
import updateElevatorData from '../jsFunctions/setters/updateElevatorData';
import universalFillerForUniversalTable from '../jsFunctions/getters/universalFillerForUniversalTable';
import universalUpdate from '../jsFunctions/setters/universalUpdate';

const props = defineProps({
    deleteCommand: String,
    headItems: Array,
    lastAction: Boolean,
    lastStatus: Boolean,
    api: String,
    speciallData: { type: Object, default: () => ({}) },
    searchForeignKey: String,
    exec: Boolean,
    specialGetters: String,
    columnQueue: Array,
    readonlyFields: { type: Array, default: () => [] },
    placeholders: { type: Array, default: () => [] },
    scrollWidth: Boolean,
});

let data = ref([]);
const columnWidths = [
    'w-72',
    'w-60',
    'w-80',
    'w-32',
    'w-32',
    'w-32',
    'w-60',
    'w-36',
    'w-36',
    'w-44',
    'w-24',
];
let readonlyFlag = ref('');
let selectedRow = ref(null);
let selectedRowIndex = ref(null);

// Generate a unique ID for new rows
function generateUniqueId() {
    return 'row_' + Math.random().toString(36).substr(2, 9);
}

function addLine(name) {
    const newRow = [generateUniqueId(), name, '-', '-'];
    data.value.push(newRow);
}

defineExpose({ addLine });

async function fetchData() {
    if (props.specialGetters === 'elevator') {
        const result = await elevatorFillerForUniversalTable(
            props.speciallData,
        );
        data.value = result;
    } else if (props.specialGetters === 'building') {
        const result = await universalFillerForUniversalTable(
            defaultHouseArray,
            '/getBuildingData',
            props.speciallData.adressId,
        );
        data.value = result;
    } else if (props.exec) {
        try {
            const result = await getExecData(props.api, props.searchForeignKey);
            data.value = result;
        } catch (error) {
            console.error('Ошибка при загрузке данных:', error);
        }
    } else {
        try {
            const result = await getDataForTableFill(props.api);
            data.value = result;
        } catch (error) {
            console.error('Ошибка при загрузке данных:', error);
        }
    }
}

function toggleChangableStatus(id, index) {
    readonlyFlag.value = id;
    selectedRowIndex.value = Number(index);
}

function refillDataArray(selectedRowIndex, columnIndex, id) {
    const element = document.getElementById(id);
    if (!element) return; // Safeguard against null element
    const inputs = element.getElementsByTagName('input');
    // Map DOM input index to data array index (shift by 1 due to slice(1))
    const dataIndex = columnIndex + 1;
    if (inputs[columnIndex]) {
        data.value[selectedRowIndex][dataIndex] = inputs[columnIndex].value;
    }
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
            if (oldSelectedRowIndex == null || !data.value[oldSelectedRowIndex])
                return;

            const rowId = data.value[oldSelectedRowIndex][0];
            const element = document.getElementById(rowId);
            if (!element) return;

            // Only update the editable fields (skip ID at index 0)
            data.value[oldSelectedRowIndex].slice(1).forEach((_, index) => {
                refillDataArray(oldSelectedRowIndex, index, rowId);
            });

            switch (props.deleteCommand) {
                case 'deleteManager':
                    updateManagerData(
                        data.value[oldSelectedRowIndex][0],
                        data.value[oldSelectedRowIndex][1],
                        data.value[oldSelectedRowIndex][2],
                        data.value[oldSelectedRowIndex][3],
                        data.value[oldSelectedRowIndex][4],
                    );
                    break;
                case 'deleteElevatorData':
                    updateElevatorData(
                        props.speciallData.adressId,
                        props.speciallData.name,
                        data.value[oldSelectedRowIndex][1],
                        data.value[oldSelectedRowIndex][2],
                        data.value[oldSelectedRowIndex][3],
                        props.speciallData.entrance,
                    );
                    break;
                case 'deleteBuildingData':
                    universalUpdate(
                        props.speciallData.adressId,
                        data.value[oldSelectedRowIndex][0],
                        data.value[oldSelectedRowIndex][1],
                        data.value[oldSelectedRowIndex][2],
                        '/updateHomeData',
                    );
                    break;
                default:
                    break;
            }
        }
    },
    { immediate: false },
);

onMounted(() => {
    fetchData();
});

const target = ref(null);
const handleBodyClick = (event) => {
    if (!target.value || !target.value.contains(event.target)) {
        readonlyFlag.value = undefined;
        selectedRow.value = undefined;
        selectedRowIndex.value = null;
    }
};

onMounted(() => {
    document.addEventListener('click', handleBodyClick);
});
onUnmounted(() => {
    document.removeEventListener('click', handleBodyClick);
});

function replaceTo(contractNumber, adressId) {
    window.location.href = '/contracts/' + contractNumber + '/' + adressId;
}
</script>

<template>
    <div :class="props.scrollWidth ? 'w-full overflow-x-auto' : ''">
        <table
            @click="handleBodyClick"
            class="w-full table-auto border-collapse rounded-lg shadow-sm"
            :class="props.scrollWidth ? 'min-w-max' : 'w-full table-auto'"
        >
            <thead class="bg-indigo-50 text-left text-xs text-gray-500">
                <tr :class="props.scrollWidth ? 'h-12' : ''">
                    <th
                        class="flex-wrap px-4 py-4"
                        v-for="(item, index) in props.headItems"
                        :key="item"
                        :class="[props.scrollWidth ? columnWidths[index] : '']"
                        :style="{
                            width: props.scrollWidth ? columnWidths[index] : '',
                            'white-space': 'nowrap',
                            position:
                                index === props.headItems.length - 1 &&
                                props.scrollWidth
                                    ? 'sticky'
                                    : '',
                            right:
                                index === props.headItems.length - 1 &&
                                props.scrollWidth
                                    ? '0'
                                    : '',
                            'background-color':
                                index === props.headItems.length - 1 &&
                                props.scrollWidth
                                    ? '#eef2ff'
                                    : '',
                            'z-index':
                                index === props.headItems.length - 1 &&
                                props.scrollWidth
                                    ? '10'
                                    : '',
                            'box-shadow':
                                index === props.headItems.length - 1 &&
                                props.scrollWidth
                                    ? 'inset 4px 0 6px -1px rgba(0, 0, 0, 0.1)'
                                    : '',
                        }"
                        v-html="item"
                    ></th>
                </tr>
            </thead>
            <tbody ref="target" @click.stop>
                <tr
                    :id="props.exec ? data[index].id : data[index][0]"
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
                    :key="dataItem[0]"
                >
                    <td
                        v-for="(field, indexElem) in props.exec
                            ? props.columnQueue
                            : data[index].slice(1)"
                        :key="field"
                    >
                        <TableInpueElement
                            :selected="selectedRow === dataItem"
                            :even="index % 2 !== 0"
                            :placeholder="props.placeholders[indexElem] || ''"
                            :readonly-state="
                                readonlyFlag !== dataItem[0]
                                    ? true
                                    : props.exec
                                      ? true
                                      : props.readonlyFields[indexElem]
                                        ? true
                                        : false
                            "
                            :value="props.exec ? data[index][field] : field"
                        />
                    </td>
                    <td
                        v-if="props.lastAction"
                        class="px-4 group-hover:bg-indigo-100"
                        :style="{
                            'box-shadow': props.scrollWidth
                                ? 'inset 4px 0 6px -1px rgba(0, 0, 0, 0.1)'
                                : '',
                        }"
                        :class="[
                            selectedRow === dataItem
                                ? 'bg-indigo-100'
                                : index % 2 !== 0
                                  ? 'bg-gray-50'
                                  : 'bg-white',
                            props.scrollWidth ? 'sticky right-0 z-10' : '',
                        ]"
                    >
                        <EditDeleteComponent
                            :id-to-delete="
                                props.exec ? data[index].id : data[index][0]
                            "
                            :add-data="props.speciallData.adressId"
                            :key="index"
                            :modalType="props.deleteCommand"
                            @editable="
                                props.exec
                                    ? replaceTo(
                                          props.searchForeignKey,
                                          data[index].id,
                                      )
                                    : toggleChangableStatus(dataItem[0], index)
                            "
                        />
                    </td>
                    <td v-if="props.lastStatus" class="px-4">
                        <StatusLabel :key="index" :state="true" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
