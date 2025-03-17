<script setup>
import LineSaveEntrance from './lineSaveEntrance.vue';
import RoundedArrowLineToNextPage from './roundedArrowLineToNextPage.vue';
import textHeadWithAddButton from './textHeadWithAddButton.vue';
import { ref } from 'vue';
const props = defineProps(['itemsCount']);
let showAdd = ref(false);
</script>
<template>
    <textHeadWithAddButton
        :shown="true"
        head-text="Подъезды"
        @click="showAdd = !showAdd"
    ></textHeadWithAddButton>
    <div class="space-y-3">
        <RoundedArrowLineToNextPage
            v-for="item in props.itemsCount"
            :text="'Подъезд ' + item"
            :key="item"
        ></RoundedArrowLineToNextPage>
        <LineSaveEntrance v-if="showAdd"></LineSaveEntrance>
    </div>
</template>
