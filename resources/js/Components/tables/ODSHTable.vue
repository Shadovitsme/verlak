<script setup>
import JustButton from '../justButton.vue';
import EditDeleteComponent from '../editDeleteComponent.vue';

const props = defineProps({
    avansData: Array,
    ODSHTableData: { type: Object, default: () => ({}) },
});

const placeholders = [
    'Полная стоимость',
    'Аванс',
    'Дата',
    'Комментарий',
    '% остатка',
    'Остаток',
];
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
                        v-for="(row, trIndex) in props.avansData"
                        :id="headItems[0] + String(trIndex)"
                        :class="[
                            'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100',
                            trIndex % 2 !== 0 ? 'bg-gray-50' : 'bg-white',
                        ]"
                        :key="trIndex"
                    >
                        <td class="px-4">
                            <input
                                :value="row.address"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                placeholder="Адрес"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                :value="row.fullPrice"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                :placeholder="placeholders[0]"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                :value="row.avans"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                :placeholder="placeholders[1]"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                :value="row.date"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                :placeholder="placeholders[2]"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                :value="row.comment"
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                :placeholder="placeholders[3]"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                :value="row.remainingPercent"
                                readonly
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                :placeholder="placeholders[4]"
                            />
                        </td>
                        <td class="px-4">
                            <input
                                :value="row.remainingAmount"
                                readonly
                                :class="[
                                    'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100',
                                    trIndex % 2 !== 0
                                        ? 'bg-gray-50'
                                        : 'bg-white',
                                ]"
                                :placeholder="placeholders[5]"
                            />
                        </td>
                        <td class="px-4">
                            <EditDeleteComponent
                                modal-type="deleteAvans"
                                :id-to-delete="row.avanceId"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex w-full justify-end">
            <JustButton color="blue">Добавить выплату</JustButton>
        </div>
    </div>
</template>
