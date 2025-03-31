<script setup lang="ts">
import CustomInput from '../Components/customInput.vue';
import DropdownCalendarButton from '../Components/dropdowns/dropdownCalendarButton.vue';
import DropdownInputButton from '../Components/dropdowns/dropdownInputButton.vue';
import DropdownStatusButton from '../Components/dropdowns/dropdownStatusButton.vue';
import JustButton from '../Components/justButton.vue';
import { ref } from 'vue';
import EmptyTable from '../Components/tables/emptyTable.vue';
import IconButton from '../Components/iconButton.vue';
import addNewContract from '@/Components/jsFunctions/setters/addNewContract';
import updateContract from '@/Components/jsFunctions/setters/updateContract';
import towns from '@/Components/jsFunctions/town';
let rowCounter = ref(0);
const errorState = ref(false);

const props = defineProps({
    contractNumber: String,
    organization: String,
    data: Object,
});
const headItems = [
    'Административный округ',
    'Район',
    'Адрес многоквартирного дома ',
    'Серия дома',
    'Тип проекта',
    'Дата начала',
    'Дата окончания',
    'Стоимость <br />(с НДС 20%),₽',
    'Действия',
];
const dbAdressColumnNames = [
    'adminDistrict',
    'townDistrict',
    'adress',
    'buildingSerial',
    'projectType',
    'dateStart',
    'dateEnd',
    'price',
];
function getDropDownValue(id) {
    let besideResult = document
        .getElementById(id)
        .getElementsByTagName('button')[0].textContent;
    if (
        besideResult == 'Введите названии организации' ||
        besideResult == 'Выберите дату' ||
        besideResult == 'Выберите город' ||
        besideResult == 'Выберите статус'
    ) {
        return '';
    }
    return besideResult;
}
const emit = defineEmits(['close']);

async function saveData() {
    event.preventDefault();
    let number = document
        .getElementById('contractNumber')
        .getElementsByTagName('input')[0].value;
    let organization = getDropDownValue('organization');
    let date = getDropDownValue('date');
    let town = getDropDownValue('town');
    let state = getDropDownValue('state');
    let adressData = [];
    for (let i = 0; i <= rowCounter.value - 1; i++) {
        let besideResult = {};

        dbAdressColumnNames.forEach((element, index) => {
            besideResult[element] = document
                .getElementById('table')
                .getElementsByTagName('tbody')[0]
                .getElementsByTagName('tr')
                [i].getElementsByTagName('input')[index].value;
        });
        adressData[i] = besideResult;
    }

    if (props.data) {
        try {
            await updateContract(
                props.data.id,
                number,
                organization,
                date,
                town,
                state,
                adressData,
            );
            emit('close');
        } catch (error) {
            errorState.value = true;
        }
    } else {
        try {
            await addNewContract(
                number,
                organization,
                date,
                town,
                state,
                adressData,
            );
            console.log('Contract added successfully');
            emit('close');
        } catch (error) {
            errorState.value = true;
        }
    }
}
</script>

<template>
    <div class="mx-32 mt-20 w-337 pt-12">
        <slot></slot>
        <h1 class="mb-3 text-4xl text-gray-900">Создание договора</h1>
        <p class="mb-6 text-base text-gray-700">
            {{ 'Менеджер: ' + $page.props.auth.user.name }}
        </p>
        <div class="w-full rounded-3xl bg-white p-10 shadow-sm">
            <form @submit.prevent="saveData()" id="addRoom" class="w-full">
                <p class="mb-5 text-2xl text-gray-900">Основная информация</p>
                <div class="z-20 pb-8">
                    <div id="contractNumber" class="z-20 mb-4 flex gap-x-10">
                        <div class="w-full">
                            <CustomInput
                                :errorState="errorState"
                                inputType="number"
                                :static-width="false"
                                label-text="Номер контракта"
                                placeholder="Введите номер контракта"
                                :value="
                                    props.contractNumber
                                        ? props.contractNumber
                                        : ''
                                "
                            ></CustomInput>
                            <p
                                class="mt-1.5 text-xs text-rose-600"
                                v-if="errorState"
                            >
                                Такой договор уже существует. Проверьте
                                введённый номер.
                            </p>
                        </div>

                        <div id="organization" class="z-20 w-full">
                            <DropdownInputButton
                                :static-width="false"
                                label-text="Название организации"
                                placeholder="Введите названии организации"
                                check-type="radio"
                                :label-text-arr="['ВЕРЕЛАК', 'ПСК']"
                                :value="
                                    props.data != null
                                        ? props.data.organization
                                        : ''
                                "
                            ></DropdownInputButton>
                        </div>
                        <div id="date" class="z-20 w-full">
                            <DropdownCalendarButton
                                :static-width="false"
                                label-text="Дата"
                                placeholder="Выберите дату"
                                :value="
                                    props.data != null ? props.data.date : ''
                                "
                            >
                            </DropdownCalendarButton>
                        </div>
                    </div>
                    <div id="town" class="z-10 flex w-full gap-x-10">
                        <DropdownInputButton
                            :static-width="false"
                            label-text="Город"
                            placeholder="Выберите город"
                            :value="props.data != null ? props.data.town : ''"
                            check-type="radio"
                            :label-text-arr="towns"
                        >
                        </DropdownInputButton>
                        <DropdownStatusButton
                            id="state"
                            :static-width="false"
                            label-text="Статус"
                            :value="props.data != null ? props.data.state : ''"
                            placeholder="Выберите статус"
                            check-type="radio"
                            :label-text-arr="['В работе', 'Выполнено']"
                        >
                        </DropdownStatusButton>
                    </div>
                </div>

                <div class="mt-8 w-fit">
                    <div class="mb-5 flex h-fit content-center items-center">
                        <p class="my-auto mr-4 text-2xl text-gray-900">
                            Адреса
                        </p>
                        <IconButton
                            @click="rowCounter++"
                            v-if="rowCounter > 0"
                            type="button"
                            class="my-auto rotate-45"
                            icon="/assets/icons/system/x.svg"
                            color="blue"
                        ></IconButton>
                    </div>
                    <p
                        v-if="rowCounter == 0"
                        class="mb-3 text-sm text-gray-900"
                    >
                        Адресов пока нет
                    </p>
                    <JustButton
                        @click="rowCounter++"
                        v-if="rowCounter == 0"
                        type="button"
                        class="w-full"
                        color="blue"
                        >Добавить</JustButton
                    >
                </div>
                <EmptyTable
                    @delete="rowCounter--"
                    :row-counter="rowCounter"
                    v-if="rowCounter > 0"
                    :headItems="headItems"
                    :placeholders="[
                        'Название округа',
                        'Название района',
                        'Адрес ',
                        '№',
                        'Наименование типа',
                        'дд.мм.гггг',
                        'дд.мм.гггг',
                        'Сумма',
                    ]"
                ></EmptyTable>
            </form>
        </div>
        <div class="mt-6 flex w-full justify-end">
            <JustButton type="sumbit" form="addRoom" color="blue"
                >Сохранить</JustButton
            >
        </div>
    </div>
</template>
