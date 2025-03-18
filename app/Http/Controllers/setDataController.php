<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class setDataController extends Controller
{
    private function addElevatorFromContract($adressId, $entrance, $elevatorCount)
    {
        for ($i = 0; $i < $elevatorCount; $i++) {
            DB::table('elevator')->insertGetId([
                'adressId' => $adressId,
                'name' => $i,
                'entrance' => $entrance
            ]);
        }
    }

    public function addElevator(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        DB::table('elevator')->insert(['adressId' => $data['adressId'], 'name' => $data['name'], 'entrance' => $data['entrance']]);
    }

    public function updateElevatorData(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $descriptionName = $data['descriptionName'];
        $query = DB::table('elevator')->where('adressId', '=', $data['adressId'])->where('name', '=', $data['elevatorName'])->where('entrance', '=', $data['entrance']);
        $result = $query->where('descriptionName', '=', $descriptionName)->get();
        if ($result->isEmpty()) {
            $this->insertElevatorData($data, $query);
        }
    }

    private function insertElevatorData($data, $query)
    {
        $query->insert(['descriptionName' => $data['descriptionName'],
            'descriptionValue' => $data['descriptionValue'],
            'commentValue' => $data['commentValue'], 'adressId' => $data['adressId'], 'name' => $data['elevatorName'], 'entrance' => $data['entrance']]);
        $query->where('descriptionName', '=' . NULL)->delete();
    }

    private function addAdress($adressArray, $contractId)
    {
        foreach ($adressArray as $tableRow) {
            $adressId = DB::table('adressData')->insertGetId([
                'adminDistrict' => $tableRow['adminDistrict'],
                'townDistrict' => $tableRow['townDistrict'],
                'adress' => $tableRow['adress'],
                'buildingSerial' => $tableRow['buildingSerial'],
                'projectType' => $tableRow['projectType'],
                'dateStart' => $tableRow['dateStart'],
                'dateEnd' => $tableRow['dateEnd'],
                'contractId' => $contractId,
                'price' => $tableRow['price'],
            ]);
            $entrance = $tableRow['entrance'];
            $elevatorCount = $tableRow['elevatorCount'];
            $this->addElevatorFromContract($adressId, $entrance, $elevatorCount);
        }
    }

    public function addNewContract(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $userId = Auth::user()->id;
        $contractId = DB::table('contract')->insertGetId([
            'contractNumber' => $data['contractNumber'],
            'date' => $data['date'],
            'town' => ($data['town']),
            'organization' => $data['organization'],
            'state' => $data['state'],
            'manager' => $userId,
        ]);
        $this->addAdress($data['adressData'], $contractId);
    }

    public function setNewManager(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        DB::table('users')->insert([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['pass']),
            'phone' => $data['phone'],
        ]);
    }

    public function updateManager(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (strpos($data['pass'], '*') === false) {
            DB::table('users')->where('id', $data['id'])->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['pass']),
                'phone' => $data['phone'],
            ]);
        } else {
            DB::table('users')->where('id', '=', $data['id'])->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);
        }
    }

    public function updateContract(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $contractId = $data['id'];
        DB::table('contract')->where('id', '=', $contractId)->update([
            'contractNumber' => $data['contractNumber'],
            'date' => $data['date'],
            'town' => ($data['town']),
            'organization' => $data['organization'],
            'state' => $data['state'],
        ]);
        $this->addAdress($data['adressData'], $contractId);
    }

    public function addEntrance(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $adressId = $data['id'];
        $entranceName = $data['name'];
        DB::table('elevator')->insert([
            'adressId' => $adressId,
            'entrance' => $entranceName,
            'name' => $entranceName
        ]);
    }
}
