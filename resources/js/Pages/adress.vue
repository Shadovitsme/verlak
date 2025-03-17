<script setup>
import PagePlace from '@/Components/pagePlace.vue';
import { onMounted } from 'vue';

// Объявляем пропсы
defineProps(['contractNumber', 'adressId']);

// Пример использования
onMounted(() => {
    console.log('Contract Number:', contractNumber);
    console.log('Address ID:', adressId);
});
</script>

<template>
    <PagePlace pageName="Учёт договоров"
        ><div>
            <h1>Contract Number: {{ contractNumber }}</h1>
            <p>Address ID: {{ adressId }}</p>
        </div>
    </PagePlace>
</template>
