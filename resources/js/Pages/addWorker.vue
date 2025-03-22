<script setup>
import customInput from '@/Components/customInput.vue';
import DropdownInputButton from '@/Components/dropdowns/dropdownInputButton.vue';
import Header from '@/Components/header.vue';
import JustButton from '../Components/justButton.vue';
import EmptyTable from '../Components/tables/emptyTable.vue';
import IconButton from '../Components/iconButton.vue';
import { ref } from 'vue';
import addUpdateWorker from '@/Components/jsFunctions/setters/addWorker';

let rowCounter = ref([]);
let adressCounter = ref(0);
let testRef = ref(null);

const town = ref('');
const FIO = ref('');
const adressItem = ref([]);

function addAdress() {
    adressCounter.value++;
    rowCounter.value.push(1);
    adressItem.value.push('');
}
// let dbAdressColumnNames = ['name', 'fullPrice', 'comment'];
async function saveData() {
    let workerId = await addUpdateWorker(FIO.value, town.value);
    for (let i = 0; i < adressCounter.value; i++) {
        testRef.value[i].addAdress(workerId);
    }
}
</script>

<template>
    <Header></Header>
    <div class="mx-32 mt-20 w-full max-w-[1600px] pt-12">
        <h1 class="my-auto mb-8 mr-4 text-5xl text-gray-900">
            Добавить исполнителя
        </h1>

        <div class="w-[1348px] rounded-3xl bg-white p-10 shadow-sm">
            <form @submit.prevent="saveData" id="addRoom" class="w-full">
                <p class="mb-5 text-2xl text-gray-900">Основная информация</p>
                <div class="z-20 flex gap-x-10 pb-8">
                    <customInput
                        :value="FIO"
                        :static-width="true"
                        label-text="ФИО"
                        placeholder="Введите ФИО"
                        @update:value="(newValue) => (FIO = newValue)"
                    ></customInput>

                    <DropdownInputButton
                        :value="town"
                        :static-width="true"
                        label-text="Город"
                        placeholder="Выберите город"
                        check-type="radio"
                        :label-text-arr="[
                            'Астрахань',
                            'Москва',
                            'Санкт-Петербург',
                        ]"
                        @update:value="(newValue) => (town = newValue)"
                    >
                    </DropdownInputButton>
                </div>

                <div class="mb-5 flex h-fit content-center items-center">
                    <p class="my-auto mr-4 text-2xl text-gray-900">Адреса</p>
                    <IconButton
                        @click="addAdress"
                        v-if="adressCounter > 0"
                        type="button"
                        class="my-auto rotate-45"
                        icon="/assets/icons/system/x.svg"
                        color="blue"
                    ></IconButton>
                </div>
                <div class="w-fit">
                    <p
                        v-if="adressCounter < 1"
                        class="mb-3 text-sm text-gray-900"
                    >
                        Адресов пока нет
                    </p>
                    <JustButton
                        @click="addAdress"
                        v-if="adressCounter < 1"
                        type="button"
                        class="w-full"
                        color="blue"
                        >Добавить</JustButton
                    >
                </div>
                <div v-for="i in adressCounter" class="mb-5" :key="i">
                    <customInput
                        :value="adressItem[i - 1]"
                        class="mb-5"
                        :static-width="true"
                        label-text="Адрес"
                        placeholder="Введите адрес дома"
                        @update:value="
                            (newValue) => (adressItem[i - 1] = newValue)
                        "
                    ></customInput>
                    <EmptyTable
                        modal-type="deleteWorkerAdress"
                        :all-changable="true"
                        ref="testRef"
                        :id="'table' + i"
                        :scroll-table="false"
                        :row-counter="rowCounter[i - 1]"
                        :headItems="[
                            'Общая стоимость, ₽ ',
                            'Авансы, ₽ ',
                            'Дата',
                            'Примечание',
                            'Остаток, %',
                            'Остаток, ₽',
                            'Действия',
                        ]"
                        :placeholders="[
                            'Сумма',
                            'Сумма',
                            'дд.мм.гггг',
                            'Комментарий',
                            '-',
                            '-',
                        ]"
                    ></EmptyTable>
                    <div class="mt-3 flex w-full justify-end">
                        <JustButton
                            class="w-fit"
                            @click="rowCounter[i - 1] = rowCounter[i - 1] + 1"
                            type="button"
                            color="blue"
                            >Добавить вылату</JustButton
                        >
                    </div>
                </div>
                <div class="flex w-full justify-end">
                    <JustButton type="sumbit" form="addRoom" color="blue"
                        >Сохранить</JustButton
                    >
                </div>
            </form>
        </div>
    </div>
</template>
