<script setup lang="ts">
import IconButton from './iconButton.vue';
import JustButton from './justButton.vue';
let notificateStatus = 'Default';
import DropdownLink from './DropdownLink.vue';
</script>
<template>
    <div
        class="fixed top-0 mx-auto flex h-20 w-full max-w-[1600px] bg-white pl-28 pr-32"
    >
        <div class="my-auto flex h-fit w-full justify-between">
            <div class="flex gap-3">
                <a class="my-auto" href="/contracts">
                    <JustButton color="noColor">Договоры</JustButton></a
                >
                <a class="my-auto" href="/admin"
                    ><JustButton color="noColor">Сотрудники</JustButton></a
                >
                <a class="my-auto" href="/scores"
                    ><JustButton color="noColor">Счета</JustButton></a
                >
                <a class="my-auto" href="/notifications">
                    <JustButton class="flex align-middle" color="noColor"
                        ><p class="my-auto">Уведомления</p>
                        <img
                            class="imgColorlessButton my-auto ml-2 inline-block size-5"
                            :src="
                                '/assets/icons/system/State=' +
                                notificateStatus +
                                '.svg'
                            "
                    /></JustButton>
                    <!-- TODO сделать отдельный класс для таких текстов с иконками чтоб красить иконку -->
                    <!-- TODO заставить колокольчик подкрашиваться при наведении на кнопку--></a
                >
                <a class="my-auto" href="/executors">
                    <JustButton color="noColor">Исполнители</JustButton>
                </a>
            </div>
            <div class="flex">
                <p class="my-auto mr-3.5 flex font-medium text-indigo-600">
                    {{ $page.props.auth.user.name }}
                </p>

                <DropdownLink :href="route('logout')" method="post" as="button">
                    <IconButton
                        type="button"
                        color="gray"
                        icon="/assets/icons/system/log-out.svg"
                    ></IconButton>
                </DropdownLink>
            </div>
        </div>
    </div>
</template>
<style>
.imgColorlessButton:hover {
    filter: brightness(0) saturate(100%) invert(20%) sepia(83%) saturate(3179%)
        hue-rotate(242deg) brightness(80%) contrast(96%);
}
</style>
