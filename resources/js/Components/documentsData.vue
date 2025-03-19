<script setup lang="ts">
import DocumentlittleCard from './documentlittleCard.vue';
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
const props = defineProps({
    text: String,
});
</script>

<template>
    <div class="mt-10">
        <TextHeadWithAddButton :text="props.text" :shown="true">
        </TextHeadWithAddButton>
        <div class="mt-3 flex w-full gap-2">
            <DocumentlittleCard v-for="i in 5" :key="i"></DocumentlittleCard>
        </div>
    </div>
</template>
