<script setup>
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
import ImageItem from './imageItem.vue';
const props = defineProps({
    text: String,
    imageArray: Array,
    fatherId: String,
});
</script>

<template>
    <div class="mb-3 w-full rounded-lg bg-white p-5">
        <TextHeadWithAddButton
            :shown="true"
            :text="props.text"
        ></TextHeadWithAddButton>
        <div class="mt-5 flex gap-5">
            <ImageItem
                v-for="item in props.imageArray"
                :key="item"
                :src="item"
            ></ImageItem>
        </div>
    </div>
</template>
