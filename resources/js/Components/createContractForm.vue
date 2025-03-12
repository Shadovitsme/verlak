<script setup lang="ts">
import CustomInput from './customInput.vue';
import DropdownCalendarButton from './dropdownCalendarButton.vue';
import DropdownInputButton from './dropdownInputButton.vue';
import DropdownStatusButton from './dropdownStatusButton.vue';
import JustButton from './justButton.vue';
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
                            :label-text-arr="['В работе', 'Выполнено']"
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
                    <p class="mb-5 text-2xl text-gray-900">Адреса</p>
                    <p class="mb-3 text-sm text-gray-900">Адресов пока нет</p>
                    <JustButton type="button" class="w-full" color="blue"
                        >Добавить</JustButton
                    >
                </div>
            </form>
        </div>
        <div class="mt-6 flex w-full justify-end">
            <JustButton type="sumbit" form="addRoom" color="blue"
                >Сохранить</JustButton
            >
        </div>
    </div>
</template>
