<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class getDataController extends Controller
{
    public function getAllManagers()
    {
        $managers = DB::table('users')->where('id', '>', 1)->where('active', '=', true)->get(['id', 'name', 'email', 'phone', 'password']);
        foreach ($managers as $manager) {
            $manager->password = '******';  // Маскируем пароль
        }
        return response()->json($managers->toArray());
    }

    public function getAllContracts()
    {
        $contracts = DB::table('contract')->get(['id','contractNumber','date','town','organization','manager','state']);
        foreach ($contracts as $contract) {
            $contract->manager = DB::table('users')->where('id', '=', $contract->manager)->pluck('name');
        }
        return response()->json($contracts->toArray());
    }
}
