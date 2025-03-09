<script setup>
import EditDeleteComponent from './editDeleteComponent.vue';
import StatusLabel from './statusLabel.vue';
import { ref } from 'vue';
import TableInpueElement from './tableInpueElement.vue';
const props = defineProps({
    headItems: Array,
    dataQuery: String,
    lastAction: Boolean,
    lastStatus: Boolean,
    readonlyFields: Array,
    placeholders: Array,
});

let readonlyFlag = ref(true);
let selectedRow = ref();

// TODO сделать несоклько аякс функций и вынести их в отдельные файлы для заполнения дата квери юзать чтоб понимать куда какие данные сосать
function toggleChangableStatus() {
    readonlyFlag.value = !readonlyFlag.value;
}
</script>
<template>
    <table class="w-full table-auto border-collapse shadow-sm">
        <thead class="bg-indigo-50 text-left text-gray-500">
            <tr class="h-12">
                <th class="px-4" v-for="item in props.headItems" :key="item">
                    {{ item }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                @click="selectedRow = dataItem[0]"
                :class="
                    'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100 focus:bg-indigo-100 active:bg-indigo-100 ' +
                    (selectedRow == dataItem[0]
                        ? 'bg-indigo-100'
                        : index % 2 != 0
                          ? 'bg-gray-50'
                          : 'bg-white')
                "
                v-for="(dataItem, index) in props.dataQuery"
                :key="dataItem[0]"
            >
                <td
                    class="px-4"
                    v-for="(elem, indexElem) in dataItem"
                    :key="elem"
                >
                    <TableInpueElement
                        :selected="selectedRow == dataItem[0]"
                        :even="index % 2 != 0"
                        :placeholder="props.placeholders[indexElem]"
                        :readonly-state="
                            readonlyFlag
                                ? true
                                : props.readonlyFields[indexElem]
                        "
                        :value="elem"
                    ></TableInpueElement>

                    <!-- TODO рудимент - убрать инпут как буду уверена что компонент выше сработает -->
                    <!-- <input
                        :class="
                            'h-full w-full border-none bg-none placeholder:text-gray-400 group-hover:bg-indigo-100 ' +
                            (selectedRow == dataItem[0]
                                ? 'bg-indigo-100'
                                : index % 2 != 0
                                  ? 'bg-gray-50'
                                  : 'bg-white') +
                            ' ' +
                            (props.readonlyFields[indexElem]
                                ? 'text-gray-900'
                                : 'text-gray-500')
                        "
                        :placeholder="props.placeholders[indexElem]"
                        :readonly="
                            readonlyFlag
                                ? true
                                : props.readonlyFields[indexElem]
                        "
                        :value="elem"
                    /> -->
                </td>
                <td v-if="props.lastAction">
                    <EditDeleteComponent
                        @editable="toggleChangableStatus()"
                        class="my-auto px-4"
                    ></EditDeleteComponent>
                </td>
                <td class="px-4" v-if="props.lastStatus">
                    <StatusLabel :state="true"></StatusLabel>
                    <!-- TODO допилить когда начну сосать из бд -->
                </td>
            </tr>
        </tbody>
    </table>
</template>
