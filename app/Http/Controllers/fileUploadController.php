<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Валидация файла
            $request->validate([
                'file' => 'required|file|max:10240'  // максимум 10MB
            ]);

            // Сохранение файла в storage/app/public/uploads
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $fileName, 'public');

            return response()->json([
                'success' => true,
                'path' => $path,
                'message' => 'Файл успешно загружен'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function delete(Request $request)
    {
        try {
            // Валидация запроса
            $request->validate([
                'path' => 'required|string'  // Ожидаем путь к файлу
            ]);

            $path = $request->input('path');  // Получаем путь из запроса

            // Проверяем, существует ли файл
            if (!Storage::disk('public')->exists($path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Файл не найден'
                ], 404);
            }

            // Удаляем файл
            Storage::disk('public')->delete($path);

            return response()->json([
                'success' => true,
                'message' => 'Файл успешно удален'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
