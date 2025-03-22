<script setup lang="ts">
import DropdownInputButton from '@/Components/dropdowns/dropdownInputButton.vue';
import IconButton from '@/Components/iconButton.vue';
import Header from '@/Components/header.vue';
import RoundedArrowLineToNextPage from '@/Components/roundedArrowLineToNextPage.vue';
import { onMounted, ref, computed } from 'vue';
import getAllWorkerData from '@/Components/jsFunctions/getters/getAllWorkerData.js';
import workerData from '@/Layouts/workerData.vue';

const data = ref();
const town = ref();
const selected = ref();
console.log(selected.value);

async function fetchData() {
    let result = await getAllWorkerData();
    data.value = result;
}
onMounted(() => {
    fetchData();
});

const filteredData = computed(() => {
    if (data.value == undefined) {
        return;
    }
    if (!town.value) {
        return data.value;
    }
    return data.value.filter((item) => item.town === town.value);
});
</script>

<template>
    <Header></Header>
    <div
        class="mx-32 mt-20 w-full max-w-[1600px] pt-12"
        v-if="selected == undefined"
    >
        <div class="mb-8 flex">
            <h1 class="my-auto mr-4 text-5xl text-gray-900">Исполнители</h1>
            <a href="/addWorker">
                <IconButton
                    class="my-auto rotate-45"
                    color="blue"
                    icon="/assets/icons/system/x.svg"
                ></IconButton
            ></a>
        </div>
        <DropdownInputButton
            :value="town"
            :static-width="true"
            label-text="Город"
            placeholder="Выберите город"
            check-type="radio"
            :label-text-arr="['Астрахань', 'Москва', 'Санкт-Петербург']"
            @update:value="(newValue) => (town = newValue)"
        >
        </DropdownInputButton>
        <div class="z-0 mt-14 w-[1348px] space-y-5">
            <RoundedArrowLineToNextPage
                v-for="(item, index) in filteredData"
                @click="selected = index"
                :text="item.name"
                :key="item.id"
            ></RoundedArrowLineToNextPage>
        </div>
    </div>
    <workerData
        v-if="selected != undefined && data != undefined"
        :data="data[selected]"
    ></workerData>
</template>
