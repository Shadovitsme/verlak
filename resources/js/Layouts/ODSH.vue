<script setup>
import CustomInput from '@/Components/customInput.vue';
import IconButton from '@/Components/iconButton.vue';
import getODSH from '@/Components/jsFunctions/getters/getODSH';
import sendHeadODSH from '@/Components/jsFunctions/setters/sendHeadODSHDataToDB';
import JustButton from '@/Components/justButton.vue';
import RoundedArrowLineDropdown from '@/Components/roundedArrowLineDropdown.vue';
import ODSHTable from '@/Components/tables/ODSHTable.vue';
import { ref, onMounted } from 'vue';

const props = defineProps({
    adressId: String,
    entrance: String,
    customerProps: { type: String, default: () => '' },
    Adress: { type: String, default: () => '' },
    Manager: { type: String, default: () => '' },
    Phone: { type: String, default: () => '' },
    SizeProps: { type: String, default: () => '' },
});

const editMode = ref(false);
const customer = ref('');
const size = ref('');
const data = ref();

function updateHeadOdsh() {
    sendHeadODSH(props.adressId, props.entrance, customer.value, size.value);
    editMode.value = false;
}

onMounted(() => {
    fetchData(props.adressId, props.entrance);
});

async function fetchData(adressId, entranceName) {
    try {
        const result = await getODSH(adressId, entranceName);
        data.value = result;
        if (data.value != undefined) {
            customer.value =
                data.value.customer != undefined ? data.value.customer : '';
            size.value = data.value.sizeT != undefined ? data.value.sizeT : '';
        } else {
            customer.value = '';
            size.value = '';
        }
    } catch (error) {
        console.error('Ошибка при загрузке данных:', error);
    }
}
</script>

<template>
    <div class="mt-8">
        <div class="mb-6 flex w-full justify-between">
            <div>
                <div class="mb-5 flex items-center gap-4">
                    <p class="text-2xl text-gray-900">ОДШ</p>
                    <IconButton
                        @click="editMode = true"
                        color="blue"
                        icon="/assets/icons/system/edit.svg"
                    ></IconButton>
                </div>
                <p v-if="!editMode" class="text-gray-700">
                    {{ 'Заказчик: ' + customer }}
                </p>
                <CustomInput
                    class="mb-3"
                    :value="customer"
                    v-if="editMode"
                    :static-width="true"
                    label-text="Заказчик"
                    @update:value="(newValue) => (customer = newValue)"
                ></CustomInput>
                <p class="text-gray-700">
                    {{ 'Адресс: ' + (data != undefined ? data.adressId : '') }}
                </p>
                <p class="text-gray-700">
                    {{
                        'Сотрудник: ' +
                        (data != undefined ? data.manager.name : '')
                    }}
                </p>
                <p class="text-gray-700">
                    {{
                        'Телефон: ' +
                        (data != undefined ? data.manager.phone : '')
                    }}
                </p>
                <CustomInput
                    class="mt-3"
                    :value="size"
                    v-if="editMode"
                    :static-width="true"
                    label-text="Размер"
                    @update:value="(newValue) => (size = newValue)"
                ></CustomInput>
                <p v-if="!editMode" class="mt-10 text-gray-700">
                    {{ 'Размер С: ' + size }}
                </p>
                <JustButton
                    class="mt-3"
                    v-if="editMode"
                    @click="updateHeadOdsh"
                    color="blue"
                    >Сохранить</JustButton
                >
            </div>
            <img class="shrink-0" src="/assets/pictures/lifti project 2.png" />
        </div>
        <RoundedArrowLineDropdown :hide-button="true" text="Таблица">
            <ODSHTable
                :adress-id="props.adressId"
                :entrance="props.entrance"
                :-o-d-s-h-table-data="data.ODSHTableData"
            ></ODSHTable>
        </RoundedArrowLineDropdown>
    </div>
</template>
