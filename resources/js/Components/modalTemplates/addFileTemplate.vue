<template>
    <div class="file-upload">
        <input
            type="file"
            ref="fileInput"
            @change="handleFileChange"
            class="form-control"
        />
        <!-- Кнопка "Загрузить" убирается, так как submit теперь управляется родителем -->

        <!-- Список загруженных файлов -->
        <div v-if="uploadedFiles.length" class="mt-3">
            <h5>Загруженные файлы:</h5>
            <ul>
                <li v-for="(file, index) in uploadedFiles" :key="index">
                    {{ file.name }}
                    <button
                        @click="deleteFile(file.path)"
                        class="btn btn-danger btn-sm ml-2"
                    >
                        Удалить
                    </button>
                </li>
            </ul>
        </div>

        <div
            v-if="message"
            :class="['mt-2', success ? 'text-success' : 'text-danger']"
        >
            {{ message }}
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

// Реактивные переменные
const fileInput = ref(null);
const file = ref(null);
const uploading = ref(false);
const message = ref('');
const success = ref(false);
const uploadedFiles = ref([]);

// Обработка выбора файла
const handleFileChange = (event) => {
    file.value = event.target.files[0];
    message.value = '';
};
const props = defineProps(['folder', 'fatherId', 'tableName']);
// Функция загрузки файла, которая будет вызвана родителем
const uploadFile = async () => {
    if (!file.value) {
        message.value = 'Выберите файл перед отправкой';
        success.value = false;
        return;
    }

    uploading.value = true;
    const formData = new FormData();
    formData.append('file', file.value);
    formData.append('folder', props.folder);
    formData.append('fatherId', props.fatherId);
    formData.append('tableName', props.tableName);

    try {
        const response = await axios.post('/upload-file', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        success.value = true;
        message.value = response.data.message;
        uploadedFiles.value.push({
            name: file.value.name,
            path: response.data.path,
        });
        fileInput.value.value = '';
        file.value = null;
    } catch (error) {
        success.value = false;
        message.value =
            error.response?.data?.message || 'Ошибка при загрузке файла';
    } finally {
        uploading.value = false;
    }
};

// Функция удаления файла
const deleteFile = async (path) => {
    if (!confirm('Вы уверены, что хотите удалить этот файл?')) return;

    try {
        const response = await axios.post('/delete-file', { path });

        success.value = true;
        message.value = response.data.message;
        uploadedFiles.value = uploadedFiles.value.filter(
            (file) => file.path !== path,
        );
    } catch (error) {
        success.value = false;
        message.value =
            error.response?.data?.message || 'Ошибка при удалении файла';
    }
};

// Экспортируем uploadFile для вызова из родителя
defineExpose({
    uploadFile,
});
</script>
