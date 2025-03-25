<script setup>
import IconButton from './iconButton.vue';
import JustButton from './justButton.vue';
import DropdownLink from './DropdownLink.vue';

// Статус уведомлений
let notificateStatus = 'Default';

// Разбиваем URL для определения текущей страницы
let locationParts = location.href.split('/');
let lastPart = locationParts[locationParts.length - 1];

// Получаем ID текущего пользователя из props Inertia
</script>

<template>
    <div
        class="fixed top-0 z-30 mx-auto flex h-20 w-full max-w-[1600px] bg-white pl-28 pr-32"
    >
        <div class="my-auto flex h-fit w-full justify-between">
            <div class="flex gap-3">
                <a class="my-auto" href="/contracts">
                    <JustButton
                        :selected="
                            lastPart == 'contracts' || lastPart == 'dashboard'
                        "
                        color="noColor"
                        >Договоры</JustButton
                    ></a
                >
                <!-- Условная отрисовка для "Сотрудники" -->
                <a
                    v-if="$page.props.auth.user.id === 1"
                    class="my-auto"
                    href="/admin"
                >
                    <JustButton :selected="lastPart == 'admin'" color="noColor"
                        >Сотрудники</JustButton
                    ></a
                >
                <a class="my-auto" href="/scores">
                    <JustButton :selected="lastPart == 'scores'" color="noColor"
                        >Счета</JustButton
                    ></a
                >
                <a class="my-auto" href="/notifications">
                    <JustButton
                        :selected="lastPart == 'notifications'"
                        class="flex align-middle"
                        color="noColor"
                        ><p class="my-auto">Уведомления</p>
                        <img
                            class="imgColorlessButton my-auto ml-2 inline-block size-5"
                            :src="
                                '/assets/icons/system/State=' +
                                notificateStatus +
                                '.svg'
                            "
                        />
                    </JustButton>
                </a>
                <!-- Условная отрисовка для "Выплаты" -->
                <a
                    v-if="$page.props.auth.user.id === 1"
                    class="my-auto"
                    href="/executors"
                >
                    <JustButton
                        :selected="lastPart == 'executors'"
                        color="noColor"
                        >Выплаты</JustButton
                    >
                </a>
            </div>
            <div class="flex">
                <p
                    class="my-auto mr-3.5 flex-shrink-0 whitespace-nowrap font-medium text-indigo-600"
                >
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
