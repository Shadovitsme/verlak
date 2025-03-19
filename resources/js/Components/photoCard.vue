<script setup>
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
import ImageItem from './imageItem.vue';
const props = defineProps({
    text: String,
    imageArray: Array,
});
</script>

<template>
    <div class="rounded-lg bg-white">
        <TextHeadWithAddButton
            :shown="true"
            :text="props.text"
        ></TextHeadWithAddButton>
        <div class="mt-5 gap-5">
            <ImageItem
                v-for="item in props.imageArray"
                :key="item"
                :src="item"
            ></ImageItem>
        </div>
    </div>
</template>
