<script setup lang="ts">
import CustomInput from '../customInput.vue';
</script>

<template>
    <h1 class="mb-5 text-center text-2xl text-gray-900">Добавить сотрудника</h1>
    <div class="space-y-5">
        <CustomInput
            :static-width="true"
            placeholder="Введите данные"
            label-text="ФИО"
        ></CustomInput
        ><CustomInput
            :static-width="true"
            placeholder="Введите почту"
            label-text="Почта"
        ></CustomInput
        ><CustomInput
            :static-width="true"
            placeholder="Введите номер телефона"
            label-text="Телефон"
        ></CustomInput
        ><CustomInput
            :static-width="true"
            placeholder="Введите пароль"
            label-text="Пароль"
        ></CustomInput>
    </div>
</template>
