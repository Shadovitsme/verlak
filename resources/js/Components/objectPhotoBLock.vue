<script setup>
import PhotoCard from './photoCard.vue';
import { onMounted, ref } from 'vue';
import getExecData from './jsFunctions/getters/getExecData';
onMounted(() => {
    fetchData(props.id);
});
const props = defineProps({
    id: String,
});
let data = ref();
async function fetchData(adressId) {
    try {
        const result = await getExecData('/getPictures', adressId);
        data.value = result;
        console.log(data.value);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
</script>

<template>
    <div class="mt-10">
        <p class="mb-3 text-2xl text-gray-900">Фото объекта</p>
        <PhotoCard
            :adress-id="props.id"
            :father-id="item.id"
            :image-array="item.picturesArray"
            v-for="item in data"
            :text="item.name"
            :key="item"
        ></PhotoCard>
    </div>
</template>
