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

    public function getExecEntrance(Request $request)
    {
        $adressId = $request->header('adressId');
        $entranceName = $request->header('entranceName');
        $entranceData = DB::table('elevator')->where('adressId', '=', $adressId)->where('entrance', '=', $entranceName)->groupBy('name')->get();
        return response()->json($entranceData);
    }

    public function getCurrentAdressData(Request $request)
    {
        $adressId = $request->header('byWhatChoose');
        $adressData = DB::table('adressData')->where('id', '=', $adressId)->get()[0];
        $adressData->entranceCount = DB::table('elevator')->where('adressId', '=', $adressId)->groupBy('entrance')->get();

        return response()->json($adressData);
    }

    public function getExecElevator(Request $request)
    {
        $adressId = $request->header('adressId');
        $elevatorName = $request->header('elevatorName');
        $entrance = $request->header('entrance');

        $adressData = DB::table('elevator')->where('adressId', '=', $adressId)->where('name', '=', $elevatorName)->where('entrance', '=', $entrance)->get();

        return response()->json($adressData);
    }

    public function getAdressesforContract(Request $request)
    {
        $contractNumber = $request->header('byWhatChoose');
        $contractId = DB::table('contract')->where('contractNumber', '=', $contractNumber)->pluck('id');
        $adressData = DB::table('adressData')->where('contractId', '=', $contractId)->get();
        foreach ($adressData as $value) {
            $value->elevatorCount = DB::table('elevator')->where('adressId', '=', $value->id)->count();
            $value->entrance = DB::table('elevator')->where('adressId', '=', $value->id)->count();
        }
        return response()->json($adressData->toArray());
    }

    public function getBuildingData(Request $request)
    {
        $adressId = $request->header('Id');
        $buildingData = DB::table('building')->where('adressId','=',$adressId)->get();
        return response()->json($buildingData->toArray());
    }
}
