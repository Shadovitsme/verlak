<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import StatusLabel from '../statusLabel.vue';
import { ref, onMounted } from 'vue';
import TableInpueElement from '../tableInpueElement.vue';
import getDataForTableFill from '../jsFunctions/getters/getDataForTableFill.js';
import { watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    deleteCommand: String,
    headItems: Array,
    lastAction: Boolean,
    lastStatus: Boolean,
    api: String,
    elevatorData: Object,
    searchForeignKey: String,
    // TODO заменить эксек на стринг
    exec: Boolean,
    specialGetters: String,
    columnQueue: Array,
    readonlyFields: { type: Array, default: () => [] },
    placeholders: { type: Array, default: () => [] },
});

let data = ref([]);
const columnWidths = ref([]);
let readonlyFlag = ref('');
let selectedRow = ref(null);
let selectedRowIndex = ref();

async function fetchData() {
    if (props.specialGetters == 'elevator') {
        const elevatorArrName = elevatorDefaultArray;
        elevatorArrName.forEach((element) => {
            data.value.push([element, props.elevatorData.descriptionValue,'']);
        });
        // TODO вынести в отдельную функцию чтоб там еще заполнять доп датой
        console.log(data.value);
        return 0;
    }
    if (props.exec) {
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
                    switch (props.page) {
                        case 'managers':
                            updateManagerData(
                                id,
                                data.value[oldSelectedRowIndex][1],
                                data.value[oldSelectedRowIndex][2],
                                data.value[oldSelectedRowIndex][3],
                                data.value[oldSelectedRowIndex][4],
                            );
                            break;

                        default:
                            break;
                    }

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
import getExecData from '../jsFunctions/getters/getExecData';
import elevatorDefaultArray from '../jsFunctions/elevatorDefaultArray';
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
        class="w-full border-collapse rounded-lg shadow-sm"
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
                :key="index"
            >
                <td
                    class="px-4"
                    v-for="(field, indexElem) in props.exec
                        ? props.columnQueue
                        : props.specialGetters != null
                          ? data[index]
                          : data[index].slice(1)"
                    :key="field"
                >
                    <TableInpueElement
                        :selected="selectedRow === dataItem"
                        :even="index % 2 !== 0"
                        :placeholder="props.placeholders[indexElem] || ''"
                        :readonly-state="
                            readonlyFlag != dataItem[0]
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
                <td v-if="props.lastAction" class="px-4">
                    <EditDeleteComponent
                        :id-to-delete="
                            props.exec ? data[index].id : data[index][0]
                        "
                        :key="index"
                        :modalType="props.deleteCommand"
                        @editable="
                            props.exec
                                ? router.visit(
                                      `/contracts/${props.searchForeignKey}/${data[index].id}`,
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
</template>
