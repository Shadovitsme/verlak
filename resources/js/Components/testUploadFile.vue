<template>
    <div class="file-upload">
        <input
            type="file"
            ref="fileInput"
            @change="handleFileChange"
            class="form-control"
        />
        <button
            @click="uploadFile"
            :disabled="!file || uploading"
            class="btn btn-primary mt-2"
        >
            {{ uploading ? 'Загрузка...' : 'Загрузить' }}
        </button>

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

<script>
import axios from 'axios';

export default {
    name: 'FileUpload',
    data() {
        return {
            file: null,
            uploading: false,
            message: '',
            success: false,
            uploadedFiles: [], // Массив для хранения загруженных файлов
        };
    },
    methods: {
        handleFileChange(event) {
            this.file = event.target.files[0];
            this.message = '';
        },
        async uploadFile() {
            if (!this.file) return;

            this.uploading = true;
            const formData = new FormData();
            formData.append('file', this.file);

            try {
                const response = await axios.post('/upload-file', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                this.success = true;
                this.message = response.data.message;
                // Добавляем файл в список загруженных
                this.uploadedFiles.push({
                    name: this.file.name,
                    path: response.data.path,
                });
                this.$refs.fileInput.value = '';
                this.file = null;
            } catch (error) {
                this.success = false;
                this.message =
                    error.response?.data?.message ||
                    'Ошибка при загрузке файла';
            } finally {
                this.uploading = false;
            }
        },
        async deleteFile(path) {
            if (!confirm('Вы уверены, что хотите удалить этот файл?')) return;

            try {
                const response = await axios.post('/delete-file', { path });

                this.success = true;
                this.message = response.data.message;
                // Удаляем файл из списка
                this.uploadedFiles = this.uploadedFiles.filter(
                    (file) => file.path !== path,
                );
            } catch (error) {
                this.success = false;
                this.message =
                    error.response?.data?.message ||
                    'Ошибка при удалении файла';
            }
        },
    },
};
</script>


