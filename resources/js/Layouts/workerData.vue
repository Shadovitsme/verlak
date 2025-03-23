<script setup>
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import IconButton from '@/Components/iconButton.vue';
import OpenModal from '@/Components/openModal.vue';
import { ref } from 'vue';
import EmptyTable from '@/Components/tables/emptyTable.vue';
import WorkerTable from '@/Components/tables/workerTable.vue';
import JustButton from '@/Components/justButton.vue';

const props = defineProps({
    data: Object,
});
const toggleModal = ref(false);
const customAdresses = ref([]);
const customAvance = ref([]);
const customIdCounter = ref(0);
let testRef = ref(null);
console.log(props.data);

function addAvance(id) {
    customAvance.value.push({
        comment: '',
        date: '',
        value: 0,
        workerAdressId: id,
    });
}

function addAdress() {
    customAdresses.value.push({
        id: customIdCounter.value,
        fullPrice: 0,
        name: '',
        workerId: props.data.workerId,
    });
    addAvance(customIdCounter.value);
    customIdCounter.value++;
}

function getAvanceByWorkerAdressId(id) {
    return customAvance.value.filter((avance) => avance.workerAdressId === id);
}
</script>

<template>
    <OpenModal
        :toggle-modal="toggleModal"
        @close="toggleModal = !toggleModal"
        :id-to-delete="data.id"
        modal-type="deleteWorker"
    ></OpenModal>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <div class="mb-6 flex w-full justify-between">
            <TextHeadWithAddButton
                @add-item="addAdress"
                :shown="true"
                :text="props.data.name"
            ></TextHeadWithAddButton>
            <div class="flex h-11 gap-x-3">
                <a :href="'/updateWorker/' + props.data.id">
                    <IconButton
                        color="gray"
                        icon="./assets/icons/system/edit.svg"
                    ></IconButton
                ></a>

                <IconButton
                    @click="toggleModal = !toggleModal"
                    color="gray"
                    icon="./assets/icons/system/delete.svg"
                ></IconButton>
            </div>
        </div>
        <WorkerTable
            v-for="item in data.adressData"
            :key="item.id"
            :avansData="
                data.avansData.filter(
                    (avans) => avans.workerAdressId === item.id,
                )
            "
            :adress-data="item"
        ></WorkerTable>
        <div v-for="item in customIdCounter" :key="item">
            <EmptyTable
                modal-type="deleteWorkerAdress"
                :all-changable="true"
                ref="testRef"
                :id="'table' + i"
                :scroll-table="false"
                :row-counter="
                    getAvanceByWorkerAdressId(customAdresses[item - 1].id)
                        .length
                "
                :headItems="[
                    'Адрес',
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
                    @click="addAvance(customAdresses[item - 1].id)"
                    type="button"
                    color="blue"
                    >Добавить вылату</JustButton
                >
            </div>
        </div>
    </div>
</template>
