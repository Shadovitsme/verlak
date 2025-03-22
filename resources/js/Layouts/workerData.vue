<script setup>
import TextHeadWithAddButton from '@/Components/textHeadWithAddButton.vue';
import IconButton from '@/Components/iconButton.vue';

const props = defineProps({
    data: Object,
});
</script>

<template>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <div class="flex w-full justify-between">
            <TextHeadWithAddButton
                :shown="true"
                :text="props.data.name"
            ></TextHeadWithAddButton>
            <div class="flex h-11 gap-x-3">
                <IconButton
                    color="gray"
                    icon="./assets/icons/system/edit.svg"
                ></IconButton>
                <IconButton
                    color="gray"
                    icon="./assets/icons/system/delete.svg"
                ></IconButton>
            </div>
        </div>
    </div>
</template>
