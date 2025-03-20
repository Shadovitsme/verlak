<script setup>
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref, onMounted, onUnmounted } from 'vue';
import { watch } from 'vue';
import addUpdateContactPerson from '../jsFunctions/setters/addUpdateContactPerson';

const props = defineProps({
    headItems: Array,
    placeholders: { type: Array, default: () => [] },
    rowCounter: Number,
    allChangable: Boolean,
    addData: Object,
    valueData: Array,
});

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
        inputs.forEach((input, index) => {
            console.log(`${props.headItems[index]}: ${input.value || 'empty'}`);
            dataInputArr.push(input.value);
        });
        addUpdateContactPerson(
            dataInputArr[0],
            dataInputArr[1],
            dataInputArr[2],
            dataInputArr[3],
            props.addData.groupId,
            '',
        );
    }
});
</script>

<template>
    <div class="w-full overflow-x-auto">
        <table
            id="table"
            @click="handleBodyClick"
            class="min-w-max table-fixed border-collapse rounded-lg shadow-sm"
        >
            <thead class="rounded-lg bg-indigo-50 text-left text-gray-500">
                <tr class="h-12 rounded-lg">
                    <th
                        class="px-4 text-xs text-gray-500"
                        :class="columnWidths[index]"
                        v-for="(item, index) in props.headItems"
                        :key="item"
                    >
                        {{ item }}
                    </th>
                </tr>
            </thead>
            <tbody ref="target" @click.stop>
                <tr
                    v-for="count in props.rowCounter"
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
                            id-to-delete="1"
                            :key="index"
                            modalType="deleteManager"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
