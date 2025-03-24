<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import { ref, onMounted } from 'vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import DocumentlittleCard from '@/Components/documentlittleCard.vue';
import JustButton from '@/Components/justButton.vue';
import addAcceptAndDisgard from '@/Components/jsFunctions/setters/addAcceptAndDisgard';
let data = ref(null);

async function fetchData() {
    try {
        const result = await getExecData('/getAllAccountancy');
        data.value = result;
        console.log(data.value);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
function accept(id) {
    addAcceptAndDisgard(id, true);
}

function getFileNameFromPath(path) {
    return path.split('/').pop() || '';
}
onMounted(() => {
    fetchData();
});
</script>

<template>
    <PagePlace add-modal-type="addFile" pageName="Счета">
        <div v-if="data" class="w-[1348px] space-y-3">
            <RoundedArrowLineDropdown
                :hideButton="true"
                v-for="item in data.accountancyData"
                :key="item"
                :text="getFileNameFromPath(item.pathToDirectory)"
            >
                <DocumentlittleCard
                    :text="getFileNameFromPath(item.pathToDirectory)"
                ></DocumentlittleCard>
                <p class="mb-2.5 mt-5 text-sm font-bold text-gray-900">
                    Согласовали
                </p>
                <ol class="space-y-1">
                    <li
                        class="text-sm text-gray-900"
                        v-for="(item, index) in data.acceptData"
                        :key="index"
                    >
                        {{ index + 1 }}. {{ item.userId }}
                    </li>
                </ol>
                <p class="mb-2.5 mt-5 text-sm font-bold text-gray-900">
                    Не согласовали
                </p>
                <ol>
                    <li v-for="(item, index) in data.disgardData" :key="index">
                        {{ index + 1 }}. {{ item.userId }}
                    </li>
                </ol>
                <div class="flex gap-5">
                    <JustButton @click="accept(item.id)" color="blue"
                        >Согласовать</JustButton
                    >
                    <JustButton color="dark">Не согласовать</JustButton>
                </div>
                <div>


                </div>
            </RoundedArrowLineDropdown>
        </div>
    </PagePlace>
</template>
