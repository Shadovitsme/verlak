<script setup>
import RoundedArrowLineToNextPage from './roundedArrowLineToNextPage.vue';
import textHeadWithAddButton from './textHeadWithAddButton.vue';
const props = defineProps(['itemsCount']);
</script>
<template>
    <textHeadWithAddButton
        :shown="true"
        head-text="Подъезды"
    ></textHeadWithAddButton>
    <div>
        <RoundedArrowLineToNextPage
            v-for="item in props.itemsCount"
            :text="'Подъезд ' + item"
            :key="item"
        ></RoundedArrowLineToNextPage>
    </div>
</template>
