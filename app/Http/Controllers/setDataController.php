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

    private function addAdress($adressArray, $contractId)
    {
        var_dump($adressArray);
        $adressId = DB::table('adressData')->insertGetId([
            'adminDistrict' => $adressArray['adminDistrict'],
            'townDistrict' => $adressArray['townDistrict'],
            'adress' => $adressArray['adress'],
            'buildingSerial' => $adressArray['buildingSerial'],
            'projectType' => $adressArray['projectType'],
            'dateStart' => $adressArray['dateStart'],
            'dateEnd' => $adressArray['dateEnd'],
            'contractId' => $contractId,
            'price' => $adressArray['price'],
        ]);
        $entrance = $adressArray['entrance'];
        $elevatorCount = $adressArray['elevatorCount'];
        $this->addElevatorFromContract($adressId, $entrance, $elevatorCount);
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
        echo ('hi');
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
}
