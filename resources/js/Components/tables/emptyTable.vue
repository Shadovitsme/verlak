<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted, defineExpose } from 'vue';
import { watch } from 'vue';
import addUpdateContactPerson from '../jsFunctions/setters/addUpdateContactPerson';
import getExecData from '../jsFunctions/getters/getExecData';
import universalUpdate from '../jsFunctions/setters/universalUpdate';
import addWorkerAdress from '../jsFunctions/setters/addWorkerAdress';

const props = defineProps({
    headItems: Array,
    placeholders: { type: Array, default: () => [] },
    rowCounter: Number,
    allChangable: Boolean,
    addData: { type: Object, default: () => ({}) },
    modalType: { type: String, default: '' },
    scrollTable: { type: Boolean, default: true },
});

// Реактивные данные таблицы
const data = ref([]);

// Загрузка данных или инициализация для нового modalType
async function fetchData() {
    let result;
    switch (props.modalType) {
        case 'deleteContact':
            result = await getExecData(
                '/getContactPersonData',
                props.addData.groupId,
            );
            data.value = result || [];
            break;
        case 'deleteMontazh':
            result = await getExecData(
                '/universalGetter',
                props.addData.adressId,
                'adressId',
                'montazh',
            );
            data.value = result || [];
            break;
        case 'deleteMaterial':
            result = await getExecData(
                '/universalGetter',
                props.addData.adressId,
                'adressId',
                'buildingMaterials',
            );
            data.value = result || [];
            break;
        case 'deleteWorkerAdress': // Новый modalType без БД
            data.value = Array(props.rowCounter)
                .fill()
                .map(() => ({
                    summ: '',
                    avans: '',
                    date: '',
                    comment: '', // Пример структуры, настройте под свои нужды
                }));
            break;
        default:
            data.value = Array(props.rowCounter)
                .fill()
                .map(() => ({
                    adminDistrict: '',
                    townDistrict: '',
                    adress: '',
                    buildingSerial: '',
                    projectType: '',
                    dateStart: '',
                    dateEnd: '',
                    price: '',
                }));

            break;
    }
}

const columnWidths = [
    'w-72',
    'w-60',
    'w-80',
    'w-32',
    'w-60',
    'w-36',
    'w-36',
    'w-44',
    'w-24',
];

const readonlyFlag = ref('');
const selectedRow = ref(undefined);
const selectedRowIndex = ref(undefined);

const target = ref(null);

const handleBodyClick = (event) => {
    if (!target.value?.contains(event.target)) {
        readonlyFlag.value = undefined;
        selectedRow.value = undefined;
        selectedRowIndex.value = undefined;
    }
};

function addAdress(id, adress) {
    data.value.forEach((element) => {
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
    switch (props.modalType) {
        case 'deleteContact':
            if (indexItem === 0) data.value[trIndex].name = value;
            else if (indexItem === 1) data.value[trIndex].work = value;
            else if (indexItem === 2) data.value[trIndex].phone = value;
            else if (indexItem === 3) data.value[trIndex].adress = value;
            break;
        case 'deleteMontazh':
            if (indexItem === 0) data.value[trIndex].name = value;
            else if (indexItem === 1) data.value[trIndex].phone = value;
            else if (indexItem === 2) data.value[trIndex].comment = value;
            break;
        case 'deleteMaterial':
            if (indexItem === 0) data.value[trIndex].name = value;
            else if (indexItem === 1) data.value[trIndex].summ = value;
            else if (indexItem === 2) data.value[trIndex].comment = value;
            break;
        case 'deleteWorkerAdress': // Новый modalType
            if (indexItem === 0) data.value[trIndex].summ = value;
            else if (indexItem === 1) data.value[trIndex].avans = value;
            else if (indexItem === 2) data.value[trIndex].date = value;
            else if (indexItem === 3) data.value[trIndex].comment = value;
            break;
        default:
            if (indexItem === 0) data.value[trIndex].adminDistrict = value;
            else if (indexItem === 1) data.value[trIndex].townDistrict = value;
            else if (indexItem === 2) data.value[trIndex].adress = value;
            else if (indexItem === 3)
                data.value[trIndex].buildingSerial = value;
            else if (indexItem === 4) data.value[trIndex].projectType = value;
            else if (indexItem === 5) data.value[trIndex].dateStart = value;
            else if (indexItem === 6) data.value[trIndex].dateEnd = value;
            else if (indexItem === 7) data.value[trIndex].price = value;

            break;
    }
}

function chooseValue(trIndex, indexItem) {
    if (data.value?.[trIndex]) {
        let val = data.value[trIndex];
        switch (props.modalType) {
            case 'deleteContact':
                return (
                    [val.name, val.work, val.phone, val.adress][indexItem] || ''
                );
            case 'deleteMontazh':
                return [val.name, val.phone, val.comment][indexItem] || '';
            case 'deleteMaterial':
                return [val.name, val.summ, val.comment][indexItem] || '';
            case 'deleteWorkerAdress':
                return (
                    [val.summ, val.avans, val.date, val.comment][indexItem] ||
                    ''
                );
            default:
                return (
                    [
                        val.adminDistrict,
                        val.townDistrict,
                        val.adress,
                        val.buildingSerial,
                        val.projectType,
                        val.dateStart,
                        val.dateEnd,
                        val.price,
                    ][indexItem] || ''
                );
        }
    }
    return '';
}

// Сохранение данных на сервер при смене строки (только для modalType с БД)
watch(selectedRow, async (newValue, oldValue) => {
    if (
        oldValue !== undefined &&
        data.value[oldValue - 1] &&
        props.modalType !== 'deleteWorkerAdress'
    ) {
        const val = data.value[oldValue - 1];
        switch (props.modalType) {
            case 'deleteContact':
                console.log(val);
                await addUpdateContactPerson(
                    val.name || '',
                    val.work || '',
                    val.phone || '',
                    val.adress || '',
                    props.addData.groupId,
                    val.id || '',
                );
                break;
            case 'deleteMontazh':
                await universalUpdate(
                    props.addData.adressId,
                    val.name || '',
                    val.phone || '',
                    val.comment || '',
                    '/universalUpdate',
                    val.id || '',
                    'montazh',
                );
                break;
            case 'deleteMaterial':
                await universalUpdate(
                    props.addData.adressId,
                    val.name || '',
                    val.summ || '',
                    val.comment || '',
                    '/universalUpdate',
                    val.id || '',
                    'buildingMaterials',
                );
                break;
        }
        if (props.modalType) {
            await fetchData(); // Обновляем данные после сохранения
        }
    }
});

onMounted(() => {
    document.addEventListener('click', handleBodyClick);
    fetchData();
});

onUnmounted(() => {
    document.removeEventListener('click', handleBodyClick);
});

const emits = defineEmits(['delete']);

const deleteItem = (index) => {
    data.value.splice(index, 1); // Удаляем элемент по индексу
    emits('delete');
};
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
                        v-for="(item, index) in props.headItems"
                        :key="item"
                        v-html="item"
                        :style="{
                            position:
                                index === props.headItems.length - 1 &&
                                props.scrollTable
                                    ? 'sticky'
                                    : '',
                            right:
                                index === props.headItems.length - 1 &&
                                props.scrollTable
                                    ? '0'
                                    : '',
                            'background-color':
                                index === props.headItems.length - 1 &&
                                props.scrollTable
                                    ? '#eef2ff'
                                    : '',
                            'z-index':
                                index === props.headItems.length - 1 &&
                                props.scrollTable
                                    ? '10'
                                    : '',
                            'box-shadow':
                                index === props.headItems.length - 1 &&
                                props.scrollTable
                                    ? 'inset 4px 0 6px -1px rgba(0, 0, 0, 0.1)'
                                    : '',
                        }"
                    ></th>
                </tr>
            </thead>
            <tbody ref="target" @click.stop>
                <tr
                    v-for="(count, trIndex) in props.rowCounter"
                    :id="props.headItems[0] + String(count)"
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
                        v-for="(item, index) in props.headItems.slice(1)"
                        :key="item"
                    >
                        <input
                            :value="chooseValue(trIndex, index)"
                            @input="
                                updateData(trIndex, index, $event.target.value)
                            "
                            :readonly="
                                props.modalType == 'deleteWorkerAdress'
                                    ? index == 4 || index == 5
                                    : false
                            "
                            :class="[
                                'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                selectedRow === count
                                    ? 'bg-indigo-100'
                                    : count % 2 !== 0
                                      ? 'bg-gray-50'
                                      : 'bg-white',
                            ]"
                            :placeholder="props.placeholders[index]"
                        />
                    </td>
                    <td
                        class="sticky right-0 z-10 px-4 shadow-md group-hover:bg-indigo-100"
                        :style="{
                            'box-shadow':
                                index === props.headItems.length - 1 &&
                                props.scrollTable
                                    ? 'inset 4px 0 6px -1px rgba(0, 0, 0, 0.1)'
                                    : '',
                        }"
                        :class="
                            selectedRow === count
                                ? 'bg-indigo-100'
                                : index % 2 !== 0
                                  ? 'bg-gray-50'
                                  : 'bg-white'
                        "
                    >
                        <EditDeleteComponent
                            v-if="props.modalType"
                            :id-to-delete="data?.[trIndex]?.id || 0"
                            :modalType="props.modalType"
                        />
                        <div v-else class="flex gap-3">
                            <img src="/assets/icons/system/edit.svg" />
                            <img
                                @click="deleteItem(count)"
                                src="/assets/icons/system/delete.svg"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
