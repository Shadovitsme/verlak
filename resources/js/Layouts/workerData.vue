<script setup>
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import IconButton from '@/Components/iconButton.vue';
import OpenModal from '@/Components/openModal.vue';
import { ref } from 'vue';
import WorkerTable from '@/Components/tables/workerTable.vue';
import customInput from '@/Components/customInput.vue';
import DropdownInputButton from '@/Components/dropdowns/dropdownInputButton.vue';
import addUpdateWorker from '@/Components/jsFunctions/setters/addWorker';
import town from '@/Components/jsFunctions/town';

const props = defineProps({
    data: Object,
});
const toggleModal = ref(false);
const editMode = ref(false);
const currentTown = ref(props.data.town);
const FIO = ref(props.data.name);

function replace() {
    window.location.href = '/updateWorker/' + props.data.id;
}

function editSaveEdit() {
    if (editMode.value) {
        addUpdateWorker(FIO.value, currentTown.value, props.data.id);
    }
    editMode.value = !editMode.value;
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
                v-if="!editMode"
                @add-item="replace()"
                :shown="true"
                :text="FIO"
            ></TextHeadWithAddButton>
            <div v-if="editMode" class="z-20 flex gap-x-10 pb-8">
                <customInput
                    :value="FIO"
                    :static-width="true"
                    label-text="ФИО"
                    placeholder="Введите ФИО"
                    @update:value="(newValue) => (FIO = newValue)"
                ></customInput>

                <DropdownInputButton
                    :value="currentTown"
                    :static-width="true"
                    label-text="Город"
                    placeholder="Выберите город"
                    check-type="radio"
                    :label-text-arr="town"
                    @update:value="(newValue) => (currentTown = newValue)"
                >
                </DropdownInputButton>
            </div>
            <div class="flex h-11 gap-x-3">
                <IconButton
                    @click="editSaveEdit"
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
