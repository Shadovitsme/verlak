<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class getDataController extends Controller
{
    public function getAllManagers()
    {
        $managers = DB::table('users')->where('id', '>', 1)->get(['name', 'email', 'phone', 'password']);
        foreach ($managers as $manager) {
            $manager->password = '******'; // Маскируем пароль
        }
        return response()->json($managers);
    }
}
