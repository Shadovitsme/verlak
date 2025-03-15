<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    private function findElementById($id, $table, $searchableColumn)
    {
        return DB::table($table)->where('id', '=', $id)->pluck($searchableColumn)[0];
    }

    public function getAllContracts()
    {
        $contracts = DB::table('contract')->get(['id', 'contractNumber', 'date', 'town', 'organization', 'manager', 'state']);
        foreach ($contracts as $contract) {
            $contract->manager = $this->findElementById($contract->manager, 'users', 'name');
        }
        return response()->json($contracts->toArray());
    }

    public function getExecContract(Request $request)
    {
        $contractNumber = $request->header('byWhatChoose');

        $contract = DB::table('contract')->where('contractNumber', '=', $contractNumber)->get(['id', 'contractNumber', 'date', 'town', 'organization', 'manager', 'state'])[0];

        $contract->manager = $this->findElementById($contract->manager, 'users', 'name');

        return response()->json($contract);
    }

    public function getAdressesforContract(Request $request)
    {
        $contractNumber = $request->header('byWhatChoose');
        $contractId = DB::table('contract')->where('contractNumber', '=', $contractNumber)->pluck('id');
        $adressData = DB::table('adressData')->where('contractId', '=', $contractId)->get();
        // foreach ($adressData as $value) {
        //     var_dump($$value);

        //     $value->elevatorCount = DB::table('elevator')->where('adressId', '=', $value->id)->count();
        // }
        return response()->json($adressData->toArray());
    }
}
