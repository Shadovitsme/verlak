<script setup lang="ts">
import StatusLabel from './statusLabel.vue';
import { ref } from 'vue';
import getExecData from './jsFunctions/getters/getExecData';
import TextHeadWithAddButton from './textHeadWithAddButton.vue';
import EmptyTable from './tables/emptyTable.vue';
import IconButton from './iconButton.vue';
const props = defineProps({
    id: String,
});
let data = ref();
async function fetchData() {
    try {
        const result = await getExecData('/getExecContract', props.id);
        data.value = result;
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
fetchData();
</script>

<template>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <slot></slot>

        <div class="flex w-full justify-between">
            <div>
                <p class="mb-3 text-4xl text-gray-900">
                    {{ 'Договор №' + data.contractNumber }}
                </p>
                <p class="mb-3 text-gray-700">
                    {{ 'Сотрудник: ' + $page.props.auth.user.name }}
                </p>
                <StatusLabel
                    class="mb-6"
                    :state="data.state == 'В работе'"
                ></StatusLabel>
            </div>
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

        <TextHeadWithAddButton
            :shown="true"
            head-text="Адреса"
        ></TextHeadWithAddButton>
        <EmptyTable></EmptyTable>
    </div>
</template>
