<script setup>
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import IconButton from '@/Components/iconButton.vue';
import OpenModal from '@/Components/openModal.vue';
import { ref } from 'vue';
import WorkerTable from '@/Components/tables/workerTable.vue';

const props = defineProps({
    data: Object,
});
console.log(props.data);
const toggleModal = ref(false);
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
                :shown="true"
                :text="props.data.name"
            ></TextHeadWithAddButton>
            <div class="flex h-11 gap-x-3">
                <IconButton
                    color="gray"
                    icon="./assets/icons/system/edit.svg"
                ></IconButton>
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
    </div>
</template>
