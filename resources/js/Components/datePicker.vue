<template>
    <VDatePicker v-model="date" color="indigo">
        <template #footer>
            <div class="flex w-full gap-2 px-3 pb-3">
                <justButton
                    color="gray"
                    text="Отмена"
                    @click="setToday"
                ></justButton>
                <button
                    class="w-full rounded-md bg-indigo-600 px-3 py-1 font-bold text-white hover:bg-indigo-700"
                    @click="setToday"
                >
                    Today
                </button>
            </div>
        </template>
    </VDatePicker>
</template>
<script setup>
import { ref } from 'vue';
import justButton from './justButton.vue';
const date = ref(new Date());
function setToday() {
    date.value = new Date();
}
</script>
<!-- https://vcalendar.io/?ref=madewithvuejs.com -->
