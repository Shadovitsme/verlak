<script setup>
import JustButton from '../justButton.vue';
import EditDeleteComponent from '../editDeleteComponent.vue';
import { ref } from 'vue';
import insertOdshTable from '../jsFunctions/setters/insertODSHTable';

const props = defineProps({
    ODSHTableData: { type: Object, default: () => ({}) },
    adressId: String,
    entrance: String,
});
console.log(props.ODSHTableData);

const besideOdsh = ref([
    {
        id: '',
        level: '',
        topEnter: '',
        topN: '',
        topV: '',
        leftN: '',
        leftV: '',
        rightN: '',
        rightV: '',
        summ: '',
        color: '',
    },
]);

function addRow() {
    besideOdsh.value.push({
        id: '',
        level: '',
        topEnter: '',
        topN: '',
        topV: '',
        leftN: '',
        leftV: '',
        rightN: '',
        rightV: '',
        summ: '',
        color: '',
    });
    console.log(besideOdsh.value);
}

function save() {
    insertOdshTable(besideOdsh.value, props.adressId, props.entrance);
}
</script>

<template>
    <div class="w-full">
        <div class="overflow-x-auto">
            <table
                id="table"
                class="w-full table-auto border-collapse rounded-lg shadow-sm"
            >
                <thead class="rounded-lg bg-indigo-50 text-left text-gray-500">
                    <tr class="border-b-[1px] border-gray-200">
                        <th
                            scope="col"
                            class="items-center border-r-[1px] px-4 text-xs text-gray-500"
                            rowspan="2"
                        >
                            № этажа
                        </th>
                        <th
                            scope="col"
                            class="h-12 border-x-[1px] px-4 text-xs text-gray-500"
                            colspan="3"
                        >
                            Обрамление верхнее, мм
                        </th>
                        <th
                            scope="col"
                            class="h-12 border-x-[1px] px-4 text-xs text-gray-500"
                            colspan="2"
                        >
                            Обрамление боковое <br />левое, мм
                        </th>
                        <th
                            scope="col"
                            class="h-12 border-x-[1px] px-4 text-xs text-gray-500"
                            colspan="2"
                        >
                            Обрамление боковое<br />правое, мм
                        </th>
                        <th
                            scope="col"
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            rowspan="2"
                        >
                            Количество, шт
                        </th>
                        <th
                            scope="col"
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            rowspan="2"
                        >
                            Цвет
                        </th>
                        <th
                            scope="col"
                            class="px-4 text-xs text-gray-500"
                            rowspan="2"
                        >
                            Действия
                        </th>
                    </tr>
                    <tr class="h-12">
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            Проем
                        </th>
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            H
                        </th>
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            B
                        </th>
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            H
                        </th>
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            B
                        </th>
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            H
                        </th>
                        <th
                            class="border-x-[1px] px-4 text-xs text-gray-500"
                            scope="col"
                        >
                            B
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(row, trIndex) in besideOdsh"
                        :key="trIndex"
                        :class="[
                            'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100',
                            trIndex % 2 !== 0 ? 'bg-gray-50' : 'bg-white',
                        ]"
                    >
                        <td class="px-4">
                            <input
                                v-model="row.level"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="Этаж"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.topEnter"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="Проем"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.topN"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="H"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.topV"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="B"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.leftN"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="H"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.leftV"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="B"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.rightN"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="H"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.rightV"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="B"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.summ"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="Количество"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                v-model="row.color"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="Цвет"
                            />
                        </td>
                        <td class="px-4">
                            <EditDeleteComponent
                                modal-type="deleteAvans"
                                :id-to-delete="row.id"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex w-full justify-end gap-3">
            <JustButton @click="addRow" color="blue">Добавить этаж</JustButton
            ><JustButton @click="save" color="blue">Сохранить</JustButton>
        </div>
    </div>
</template>
