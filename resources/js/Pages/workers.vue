<script setup lang="ts">
import DropdownInputButton from '@/Components/dropdowns/dropdownInputButton.vue';
import IconButton from '@/Components/iconButton.vue';
import Header from '@/Components/header.vue';
</script>

<template>
    <Header></Header>
    <div class="mx-32 mt-20 w-full max-w-[1600px] pt-12">
        <div class="mb-8 flex">
            <h1 class="my-auto mr-4 text-5xl text-gray-900">Исполнители</h1>
            <a href="/addWorker">
                <IconButton
                    class="my-auto rotate-45"
                    color="blue"
                    icon="/assets/icons/system/x.svg"
                ></IconButton
            ></a>
        </div>
        <DropdownInputButton
            :static-width="true"
            label-text="Город"
            placeholder="Выберите город"
            check-type="radio"
            :label-text-arr="['Астрахань', 'Москва', 'Санкт-Петербург']"
        ></DropdownInputButton>
    </div>
</template>
