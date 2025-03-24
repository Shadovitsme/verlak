<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import { ref, onMounted } from 'vue';
import getExecData from '@/Components/jsFunctions/getters/getExecData';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import DocumentlittleCard from '@/Components/documentlittleCard.vue';
import JustButton from '@/Components/justButton.vue';
import addAcceptAndDisgard from '@/Components/jsFunctions/setters/addAcceptAndDisgard';

let data = ref(null);

// Создаем объект для хранения состояний toggle и comment для каждого элемента
const itemStates = ref({});

async function fetchData() {
    try {
        const result = await getExecData('/getAllAccountancy');
        data.value = result;
        console.log(data.value);
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}

function accept(id) {
    addAcceptAndDisgard(id, true);
}

function disapprove(id) {
    addAcceptAndDisgard(id, false, itemStates.value[id]?.comment);
}

function getFileNameFromPath(path) {
    return path.split('/').pop() || '';
}

function toggleCommentState(id) {
    // Инициализируем состояние для элемента, если его еще нет
    if (!itemStates.value[id]) {
        itemStates.value[id] = {
            toggleComment: false,
            comment: '',
        };
    }
    // Переключаем toggleComment для конкретного элемента
    itemStates.value[id].toggleComment = !itemStates.value[id].toggleComment;
}

onMounted(() => {
    fetchData();
});
</script>

<template>
    <PagePlace add-modal-type="addFile" pageName="Счета">
        <div v-if="data" class="w-[1348px] space-y-3">
            <RoundedArrowLineDropdown
                :hideButton="true"
                v-for="item in data.accountancyData"
                :key="item.id"
                :text="getFileNameFromPath(item.pathToDirectory)"
            >
                <div class="w-fit">
                    <DocumentlittleCard
                        :text="getFileNameFromPath(item.pathToDirectory)"
                    ></DocumentlittleCard>
                    <p
                        v-if="
                            data.acceptData.filter(
                                (acceptItem) =>
                                    acceptItem.accountancyId === item.id,
                            ).length > 0
                        "
                        class="mb-2.5 mt-5 text-sm font-bold text-gray-900"
                    >
                        Согласовали
                    </p>
                    <ol class="space-y-1">
                        <li
                            class="text-sm text-gray-900"
                            v-for="(accept, index) in data.acceptData.filter(
                                (acceptItem) =>
                                    acceptItem.accountancyId === item.id,
                            )"
                            :key="index"
                        >
                            {{ index + 1 }}. {{ accept.userId }}
                        </li>
                    </ol>
                    <p
                        v-if="
                            data.disgardData.filter(
                                (acceptItem) =>
                                    acceptItem.accountancyId === item.id,
                            ).length > 0
                        "
                        class="mb-2.5 mt-5 text-sm font-bold text-gray-900"
                    >
                        Не согласовали
                    </p>
                    <ol>
                        <li
                            v-for="(disgard, index) in data.disgardData.filter(
                                (acceptItem) =>
                                    acceptItem.accountancyId === item.id,
                            )"
                            :key="index"
                            class="text-sm text-gray-900"
                        >
                            <p>{{ index + 1 }}. {{ disgard.userId }}</p>
                            <p class="ml-4 text-sm text-gray-500">
                                {{ 'Комментарий: ' + disgard.comment }}
                            </p>
                        </li>
                    </ol>
                    <div class="mt-3 flex gap-1.5 px-4 py-3">
                        <p
                            class="text-sm text-emerald-700"
                            v-if="item.hasCurrentUserAction == 'accepted'"
                        >
                            Вы согласовали
                        </p>
                        <img
                            class="h-4"
                            v-if="item.hasCurrentUserAction == 'accepted'"
                            src="/assets/icons/system/check.svg"
                            style="
                                filter: invert(27%) sepia(94%) saturate(748%)
                                    hue-rotate(113deg) brightness(93%)
                                    contrast(91%);
                            "
                        />
                        <p
                            class="text-sm text-rose-700"
                            v-if="item.hasCurrentUserAction == 'disgarded'"
                        >
                            Вы не согласовали
                        </p>
                        <img
                            v-if="item.hasCurrentUserAction == 'disgarded'"
                            class="h-5"
                            src="/assets/icons/system/x.svg"
                            style="
                                filter: invert(27%) sepia(94%) saturate(748%)
                                    hue-rotate(340deg) brightness(93%)
                                    contrast(91%);
                            "
                        />
                    </div>

                    <div
                        v-if="item.hasCurrentUserAction == 'none'"
                        class="mt-3 flex gap-5"
                    >
                        <JustButton @click="accept(item.id)" color="blue"
                            >Согласовать</JustButton
                        >
                        <JustButton
                            @click="toggleCommentState(item.id)"
                            color="dark"
                            >Не согласовать</JustButton
                        >
                    </div>
                    <p
                        v-if="itemStates[item.id]?.toggleComment"
                        class="mt-3 text-sm text-gray-900"
                    >
                        Комментарий
                    </p>
                    <div
                        v-if="itemStates[item.id]?.toggleComment"
                        class="relative mt-1.5 h-36 w-full overflow-hidden rounded-lg border-[1px] border-gray-300 bg-gray-50"
                    >
                        <textarea
                            v-model="itemStates[item.id].comment"
                            placeholder="Оставьте комментарий с причиной, по которой вы не согласовываете документ"
                            class="h-36 w-full resize-none border-none bg-gray-50 outline-none placeholder:text-gray-500 focus:border-none focus:outline-none"
                        >
                        </textarea>
                        <div
                            v-if="itemStates[item.id]?.comment"
                            class="absolute bottom-0 left-0 right-0 flex justify-end border-t-[1px] border-gray-300 p-3"
                        >
                            <JustButton
                                @click="disapprove(item.id)"
                                color="blue"
                                >Сохранить</JustButton
                            >
                        </div>
                    </div>
                </div>
            </RoundedArrowLineDropdown>
        </div>
    </PagePlace>
</template>
