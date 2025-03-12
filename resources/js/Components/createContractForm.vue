<script setup lang="ts">
import CustomInput from './customInput.vue';
import DropdownCalendarButton from './dropdowns/dropdownCalendarButton.vue';
import DropdownInputButton from './dropdowns/dropdownInputButton.vue';
import DropdownStatusButton from './dropdowns/dropdownStatusButton.vue';
import JustButton from './justButton.vue';
import { ref } from 'vue';
import EmptyTable from './tables/emptyTable.vue';
import IconButton from './iconButton.vue';
const tableShow = ref(false);
let rowCounter = ref(1);
</script>

<template>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <h1 class="mb-3 text-4xl text-gray-900">Создание договора</h1>
        <p class="mb-6 text-base text-gray-700">
            {{ 'Менеджер: ' + $page.props.auth.user.name }}
        </p>
        <div class="w-full rounded-3xl bg-white p-10 shadow-sm">
            <form id="addRoom" class="w-full">
                <p class="mb-5 text-2xl text-gray-900">Основная информация</p>
                <div class="z-20 pb-8">
                    <div class="z-20 mb-4 flex gap-x-10">
                        <CustomInput
                            :static-width="false"
                            label-text="Номер контракта"
                            placeholder="Введите номер контракта"
                        ></CustomInput>

                        <div class="z-20 w-full">
                            <DropdownInputButton
                                :static-width="false"
                                label-text="Название организации"
                                placeholder="Введите названии организации"
                                check-type="radio"
                                :label-text-arr="['верлак', 'не верлак']"
                            ></DropdownInputButton>
                        </div>
                        <div class="z-20 w-full">
                            <DropdownCalendarButton
                                :static-width="false"
                                label-text="Дата"
                                placeholder="Выберите дату"
                            >
                            </DropdownCalendarButton>
                        </div>
                    </div>
                    <div class="z-10 flex w-full gap-x-10">
                        <DropdownInputButton
                            :static-width="false"
                            label-text="Город"
                            placeholder="Выберите город"
                            check-type="radio"
                            :label-text-arr="[
                                'Астрахань',
                                'Москва',
                                'Санкт-Петербург',
                            ]"
                        >
                        </DropdownInputButton>
                        <DropdownStatusButton
                            :static-width="false"
                            label-text="Статус"
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
                            v-if="tableShow"
                            type="button"
                            class="my-auto rotate-45"
                            icon="/assets/icons/system/x.svg"
                            color="blue"
                        ></IconButton>
                    </div>
                    <p v-if="!tableShow" class="mb-3 text-sm text-gray-900">
                        Адресов пока нет
                    </p>
                    <JustButton
                        @click="tableShow = !tableShow"
                        v-if="!tableShow"
                        type="button"
                        class="w-full"
                        color="blue"
                        >Добавить</JustButton
                    >
                </div>
                <EmptyTable
                    :row-counter="rowCounter"
                    v-if="tableShow"
                    :headItems="[
                        'Административный округ',
                        'Район',
                        'Адрес многоквартирного дома ',
                        'Кол-во лифтов',
                        'Подъезд',
                        'Серия дома',
                        'Тип проекта',
                        'Дата начала',
                        'Дата окончания',
                        'Стоимость(с НДС 20%),₽',
                        'Действия',
                    ]"
                    :placeholders="[
                        'Название округа',
                        'Название района',
                        'Адрес ',
                        'n',
                        '№',
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
