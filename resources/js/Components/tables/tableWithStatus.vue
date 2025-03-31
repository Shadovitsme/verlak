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
    filters: {
        type: Object,
        default: () => ({
            city: undefined,
            organization: undefined,
            state: undefined,
        }),
    },
});

let data = ref([]);
const columnWidths = ref([]);
let readonlyFlag = ref('');
let selectedRow = ref(null);
let selectedRowIndex = ref();
let filtersObject = ref({});
let originalData = ref([]);
async function fetchData() {
    try {
        const result = await getDataForTableFill(props.api);
        data.value = result;
        originalData.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function applyFilters() {
    const { city, organization, state } = filtersObject.value;

    data.value = originalData.value.filter((row) => {
        // Проверяем, входит ли значение city (индекс 3) в массив city, если массив задан
        const matchesCity = !city || !city.length || city.includes(row[3]);
        // Проверяем, входит ли значение organization (индекс 4) в массив organization
        const matchesOrg =
            !organization ||
            !organization.length ||
            organization.includes(row[4]);
        // Проверяем, входит ли значение state (индекс 6) в массив state
        const matchesState = !state || !state.length || state.includes(row[6]);
        console.log(row);
        // Возвращаем true только если все условия совпадают (или фильтр не задан)
        return matchesCity && matchesOrg && matchesState;
    });
}
// Отслеживание изменений фильтров из props
watch(
    () => props.filters,
    (newFilters) => {
        filtersObject.value = { ...newFilters }; // Обновляем реактивный объект

        if (
            filtersObject.value.city == undefined &&
            filtersObject.value.organization.length == 0 &&
            filtersObject.value.state.length == 0
        ) {
            data.value = originalData.value;
        } else {
            applyFilters();
        }
    },
    { deep: true }, // Глубокое отслеживание объекта
);

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
function rowClick(dataItem) {
    selectedRow.value = dataItem;
    emit('rowClick', selectedRow.value[1]);
}
const emit = defineEmits(['rowClick']);
</script>

<template>
    <table class="w-[1348px] table-auto border-collapse rounded-lg shadow-sm">
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
                @click="rowClick(dataItem)"
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
                <td v-for="field in data[index].slice(1, -1)" :key="field">
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
