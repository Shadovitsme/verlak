<script setup>
import EditDeleteComponent from './editDeleteComponent.vue';
import StatusLabel from './statusLabel.vue';
import { ref } from 'vue';
const props = defineProps({
    headItems: Array,
    dataFiller: Array,
    lastAction: Boolean,
    lastStatus: Boolean,
    readonlyFields: Array,
});

let readonlyFlag = ref(true);

function toggleChanges() {
    readonlyFlag.value = !readonlyFlag.value;
}
</script>
<template>
    <!-- TODO сделать тут стилизацию -->
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
                :class="
                    'group h-14 border-y-[1px] border-gray-200 hover:bg-indigo-100 focus:bg-indigo-100 active:bg-indigo-100 ' +
                    (index % 2 != 0 ? 'bg-gray-50' : 'bg-white')
                "
                v-for="(dataItem, index) in props.dataFiller"
                :key="dataItem[0]"
            >
                <td
                    v-for="(elem, indexElem) in props.lastStatus
                        ? dataItem.length - 1
                        : dataItem"
                    :key="elem"
                >
                    <input
                        :class="
                            'h-full w-full border-none bg-none group-hover:bg-indigo-100 ' +
                            (index % 2 != 0 ? 'bg-gray-50' : 'bg-white') +
                            ' ' +
                            (props.readonlyFields[indexElem]
                                ? 'text-gray-500'
                                : 'text-gray-800')
                        "
                        :readonly="
                            props.readonlyFields[indexElem] && readonlyFlag
                        "
                        :value="props.lastStatus ? dataItem[elem - 1] : elem"
                    />
                </td>
                <td v-if="props.lastAction">
                    <EditDeleteComponent
                        @editable="toggleChanges()"
                        class="my-auto"
                    ></EditDeleteComponent>
                </td>
                <td v-if="props.lastStatus">
                    <StatusLabel :state="dataItem[-1]"></StatusLabel>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<style>
td {
    padding-inline: 16px;
}
</style>
