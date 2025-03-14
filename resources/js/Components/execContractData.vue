<script setup lang="ts">
import StatusLabel from './statusLabel.vue';
import { ref } from 'vue';
import getExecData from './jsFunctions/getters/getExecData';
const props = defineProps({
    id: String,
});
let data = ref();
async function fetchData() {
    try {
        const result = await getExecData('/getExecContract', props.id);
        data.value = result;
        console.log(data.value);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
fetchData();
</script>

<template>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <slot></slot>
        <p>{{ 'Договор №' + data.contractNumber }}</p>
        <p>{{ 'Сотрудник: ' + $page.props.auth.user.name }}</p>
        <StatusLabel :state="data.state == 'В работе'"></StatusLabel>
    </div>
</template>
