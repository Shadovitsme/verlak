<script setup lang="ts">
import CustomInput from './customInput.vue';
import DatePicker from './datePicker.vue';
import DropdownInputButton from './dropdownInputButton.vue';
import DropdownMenu from './dropdownMenu.vue';
import JustButton from './justButton.vue';
</script>

<template>
    <div class="mx-32 mt-20 w-[1348px] pt-12">
        <h1 class="mb-3 text-4xl text-gray-900">Создание договора</h1>
        <p class="mb-6 text-base text-gray-700">
            {{ 'Менеджер: ' + $page.props.auth.user.name }}
        </p>
        <div class="w-full rounded-3xl bg-white p-10">
            <form id="addRoom" class="w-full">
                <p class="mb-5 text-2xl text-gray-900">Основная информация</p>
                <div class="mb-4 flex gap-x-10">
                    <CustomInput
                        :static-width="false"
                        label-text="Номер контракта"
                        placeholder="Введите номер контракта"
                    ></CustomInput>
                    <CustomInput
                        :static-width="false"
                        label-text="Название организации"
                        placeholder="Введите названии организации"
                    ></CustomInput>
                    <div class="relative w-full">
                        <DropdownInputButton
                            :static-width="false"
                            label-text="Дата"
                            placeholder="Выберите дату"
                        >
                            <DatePicker class="mt-1.5"></DatePicker
                        ></DropdownInputButton>
                    </div>
                </div>
                <div class="mb-8 flex w-full gap-x-10">
                    <DropdownInputButton
                        :static-width="false"
                        label-text="Город"
                        placeholder="Выберите город"
                        ><DropdownMenu
                            :label-text-arr="['aa', 'dfdf', 'sdf']"
                        ></DropdownMenu>
                    </DropdownInputButton>
                    <DropdownInputButton
                        :static-width="false"
                        label-text="Статус"
                        placeholder="Выберите статус"
                    >
                    </DropdownInputButton>
                </div>
                <div class="w-fit">
                    <p class="mb-5 text-2xl text-gray-900">Адреса</p>
                    <p class="mb-3 text-sm text-gray-900">Адресов пока нет</p>
                    <JustButton type="button" class="w-full" color="blue"
                        >Добавить</JustButton
                    >
                </div>
            </form>
        </div>
        <JustButton type="sumbit" form="addRoom" color="blue"></JustButton>
    </div>
</template>
