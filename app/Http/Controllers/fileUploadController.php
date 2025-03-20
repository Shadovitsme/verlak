<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240',  // Максимум 10 МБ
                'folder' => 'nullable|string|regex:/^[a-zA-Z0-9_\/-]*$/',  // Разрешаем пустую строку
            ]);

            $folder = $request->input('folder', 'default');
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fatherId = $request->input('fatherId', 'default');
            $tableName = $request->input('tableName', 'default');
            // Формируем путь для сохранения в public/uploads
            $destinationPath = public_path("uploads/{$folder}");

            // Создаем папку, если она не существует
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Перемещаем файл в public/uploads/{$folder}
            $file->move($destinationPath, $fileName);

            // Формируем относительный путь для ответа
            $path = "uploads/{$folder}/{$fileName}";

            DB::table($tableName)->insert(['pathToDirectory' => $path, 'fatherId' => $fatherId]);

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
            $request->validate([
                'path' => 'required|string'
            ]);

            $path = $request->input('path');
            $fullPath = public_path($path);

            // Проверяем, существует ли файл
            if (!file_exists($fullPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Файл не найден'
                ], 404);
            }

            // Удаляем файл
            unlink($fullPath);

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
