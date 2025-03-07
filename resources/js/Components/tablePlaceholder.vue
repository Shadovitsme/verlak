<script setup>
import EditDeleteComponent from './editDeleteComponent.vue';

const props = defineProps({
    headItems: Array,
    dataFiller: Array,
    lastAction: Boolean,
});
</script>
<template>
    <!-- TODO сделать тут стилизацию -->
    <table class="w-full">
        <thead>
            <tr>
                <th v-for="item in props.headItems" :key="item">{{ item }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="dataItem in props.dataFiller" :key="dataItem[0]">
                <td v-for="elem in dataItem" :key="elem">
                    {{ elem }}
                </td>
                <td v-if="props.lastAction">
                    <EditDeleteComponent></EditDeleteComponent>
                </td>
            </tr>
        </tbody>
    </table>
</template>
