<script setup>
import { ref, onMounted } from 'vue';
import DocumentlittleCard from './documentlittleCard.vue';
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
import OpenModal from './openModal.vue';
import { transliterate } from 'transliteration';
import getExecData from './jsFunctions/getters/getExecData';
const props = defineProps({
    text: String,
    id: String,
    tableName: String,
    whereFetch: String,
    table: String,
});
let toggleModal = ref(false);
let folder = props.id + '/' + transliterate(props.text);
let data = ref();
onMounted(() => {
    fetchData(props.id);
});

async function fetchData(adressId) {
    try {
        const result = await getExecData(props.whereFetch, adressId);
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function getLastWordFromString(str) {
    const parts = str.split('/');
    return parts[parts.length - 1];
}
</script>

<template>
    <OpenModal
        :toggle-modal="toggleModal"
        @close="toggleModal = !toggleModal"
        :speciall-add-data="{
            folder: folder,
            fatherId: props.id,
            tableName: props.tableName,
        }"
        modal-type="addFile"
    ></OpenModal>
    <div class="mt-10">
        <TextHeadWithAddButton
            @add-item="toggleModal = !toggleModal"
            :text="props.text"
            :shown="true"
        >
        </TextHeadWithAddButton>
        <div class="mt-3 flex w-full gap-2">
            <DocumentlittleCard
                :table="props.table"
                :id="item.id"
                v-for="item in data"
                :text="getLastWordFromString(item.pathToDirectory)"
                :key="item"
            ></DocumentlittleCard>
        </div>
    </div>
</template>
