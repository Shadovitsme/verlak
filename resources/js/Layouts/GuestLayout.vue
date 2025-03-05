<script setup></script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0"
    >
        <div
            class="mt-6 w-full overflow-hidden bg-white p-10 shadow-md sm:max-w-md sm:rounded-3xl"
        >
            <slot />
        </div>
    </div>
</template>
