<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted } from 'vue';
import { watch } from 'vue';
import addUpdateContactPerson from '../jsFunctions/setters/addUpdateContactPerson';
import getExecData from '../jsFunctions/getters/getExecData';
import universalUpdate from '../jsFunctions/setters/universalUpdate';

const props = defineProps({
    headItems: Array,
    placeholders: { type: Array, default: () => [] },
    rowCounter: Number,
    allChangable: Boolean,
    addData: { type: Object, default: () => ({}) },
    modalType: { type: String, default: () => '' },
});
let data = ref();
async function fetchData() {
    let result;
    switch (props.modalType) {
        case 'deleteContactListItem':
            result = await getExecData(
                '/getContactPersonData',
                props.addData.groupId,
            );
            data.value = result;
            break;
        case 'deleteMontazh':
            result = await getExecData(
                '/universalGetter',
                props.addData.adressId,
                'adressId',
                'montazh',
            );
            data.value = result;
            break;
        default:
            break;
    }
}

const columnWidths = [
    'w-72',
    'w-60',
    'w-80',
    'w-32',
    'w-24',
    'w-32',
    'w-60',
    'w-36',
    'w-36',
    'w-44',
    'w-24',
];

let readonlyFlag = ref('');
let selectedRow = ref(undefined);
let selectedRowIndex = ref();

const target = ref(null);
const handleBodyClick = (event) => {
    if (target.value || !target.value.contains(event.target)) {
        readonlyFlag.value = undefined;
        selectedRow.value = undefined;
        selectedRowIndex.value = undefined;
    }
};

onMounted(() => {
    document.addEventListener('click', handleBodyClick);
    fetchData();
});
onUnmounted(() => {
    document.removeEventListener('click', handleBodyClick);
});

// Модифицированный watcher
watch(selectedRow, (newValue, oldValue) => {
    // Находим все инпуты в выбранной строке
    const selectedRowElement = document.getElementById(oldValue);
    const inputs = selectedRowElement?.querySelectorAll('input');

    if (inputs) {
        let dataInputArr = [];
        let val = data.value ? data.value[oldValue - 1] : ''; // Adjust if data.value is 0-based

        inputs.forEach((input) => {
            dataInputArr.push(input.value);
        });
        if (props.modalType == 'deleteContactListItem') {
            addUpdateContactPerson(
                dataInputArr[0],
                dataInputArr[1],
                dataInputArr[2],
                dataInputArr[3],
                props.addData.groupId,
                val?.id || '',
            );
        } else {
            universalUpdate(
                props.addData.adressId,
                dataInputArr[0],
                dataInputArr[1],
                dataInputArr[2],
                '/universalUpdate',
                val?.id || '',
                'montazh',
            );
        }
    }
});

// TODO узнать как добавить функцию внутрь объекта

function chooseValue(indexRow, indexItem) {
    if (data.value != undefined && data.value[indexRow] != undefined) {
        let val = data.value[indexRow];
        switch (props.modalType) {
            case 'deleteContactListItem':
                switch (indexItem) {
                    case 0:
                        return val.name;
                    case 1:
                        return val.work;
                    case 2:
                        return val.phone;
                    case 3:
                        return val.adress;
                    default:
                        break;
                }
                break;
            case 'deleteMontazh':
                switch (indexItem) {
                    case 0:
                        return val.name;
                    case 1:
                        return val.phone;
                    case 2:
                        return val.comment;

                    default:
                        break;
                }
                break;

            default:
                break;
        }
    }
    return '';
}
</script>

<template>
    <div class="w-full overflow-x-auto">
        <table
            id="table"
            @click="handleBodyClick"
            class="min-w-max border-collapse rounded-lg shadow-sm"
            :class="
                props.modalType == 'deleteContactListItem'
                    ? 'table-fixed'
                    : 'w-full table-auto'
            "
        >
            <thead class="rounded-lg bg-indigo-50 text-left text-gray-500">
                <tr class="h-12 rounded-lg">
                    <th
                        class="px-4 text-xs text-gray-500"
                        :class="
                            props.modalType == 'deleteContactListItem'
                                ? columnWidths[index]
                                : ''
                        "
                        v-for="(item, index) in props.headItems"
                        :key="item"
                    >
                        {{ item }}
                    </th>
                </tr>
            </thead>
            <tbody ref="target" @click.stop>
                <tr
                    v-for="(count, trIndex) in props.rowCounter"
                    :id="count"
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
                            :readonly="
                                props.allChangable
                                    ? false
                                    : index == 3 || index == 4
                            "
                            :class="
                                'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100 ' +
                                (selectedRow === count
                                    ? 'bg-indigo-100'
                                    : count % 2 !== 0
                                      ? 'bg-gray-50'
                                      : 'bg-white') +
                                ' '
                            "
                            :placeholder="props.placeholders[index]"
                        />
                    </td>
                    <td class="px-4">
                        <EditDeleteComponent
                            :id-to-delete="
                                data != undefined ? data[trIndex].id : 0
                            "
                            :key="index"
                            :modalType="props.modalType"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
