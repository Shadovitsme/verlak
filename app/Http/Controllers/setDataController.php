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
        } else {
            $query->where('descriptionName', '=', $descriptionName)->update(['descriptionValue' => $data['descriptionValue'],
                'commentValue' => $data['commentValue']]);
        }
    }

    private function insertElevatorData($data, $query)
    {
        $query->insert(['descriptionName' => $data['descriptionName'],
            'descriptionValue' => $data['descriptionValue'],
            'commentValue' => $data['commentValue'], 'adressId' => $data['adressId'], 'name' => $data['elevatorName'], 'entrance' => $data['entrance']]);
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
            // $entrance = $tableRow['entrance'];
            // $elevatorCount = $tableRow['elevatorCount'];
            $arr = ['До', 'В работе', 'После'];
            foreach ($arr as $value) {
                DB::table('adressPhotoUserFolders')->insert(['fatherId' => $adressId, 'name' => $value]);
            }
            // $this->addElevatorFromContract($adressId, $entrance, $elevatorCount);
        }
    }

    public function addNewContract(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $userId = Auth::user()->id;
        $exists = DB::table('contract')
            ->where('contractNumber', $data['contractNumber'])
            ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'Contract number already exists',
                'contractNumber' => $data['contractNumber']
            ], 409);
        }
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
        $exists = DB::table('contract')
            ->where('contractNumber', $data['contractNumber'])
            ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'Contract number already exists',
                'contractNumber' => $data['contractNumber']
            ], 409);
        }
        DB::table('contract')->where('id', '=', $contractId)->update([
            'contractNumber' => $data['contractNumber'],
            'date' => $data['date'],
            'town' => ($data['town']),
            'organization' => $data['organization'],
            'state' => $data['state'],
        ]);
        $this->addAdress($data['adressData'], $contractId);
    }

    public function updateHomeData(Request $request)
    {
        // TODO переделать потом чтоб сюда и материалы можно было запульнуть
        $data = json_decode($request->getContent(), true);
        $adressId = $data['id'];
        $query = DB::table('building')->where('adressId', '=', $adressId);
        $result = $query->where('name', '=', $data['name'])->get();
        if ($result->isEmpty()) {
            $this->insertUniversalData($data, $query);
        } else {
            $query->where('name', '=', $data['name'])->update(['value' => $data['value'], 'comment' => $data['comment']]);
        }
    }

    private function insertUniversalData($data, $query)
    {
        $query->insert(['adressId' => $data['id'], 'name' => $data['name'], 'value' => $data['value'], 'comment' => $data['comment']]);
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

    public function updateContactPerson(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $contactGroupId = $data['contactGroupId'];
        $name = $data['name'];
        $work = $data['work'];
        $phone = $data['phone'];
        $adress = $data['adress'];
        $idPerson = $data['idPerson'];

        if ($idPerson) {
            echo ($idPerson);
            DB::table('contactPerson')->where('id', '=', $idPerson)->update(['name' => $name, 'work' => $work, 'phone' => $phone, 'adress' => $adress]);
        } else {
            $this->addContactPerson($contactGroupId, $name, $work, $phone, $adress);
        }
    }

    public function addContactPerson($contactGroupId, $name, $work, $phone, $adress)
    {
        DB::table('contactPerson')->insert(['name' => $name, 'name' => $work, 'phone' => $phone, 'adress' => $adress, 'contactListId' => $contactGroupId]);
    }

    public function addContactFolder(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $name = $data['name'];
        DB::table('contactList')->insert([
            'name' => $name, 'adressId' => $id
        ]);
    }

    public function universalUpdate(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $name = $data['name'];
        $value = $data['value'];
        $comment = $data['comment'];
        $adressId = $data['adressId'];
        $table = $data['table'];
        $query = DB::table($table);
        $columnArr = $this->getColumnsNames($table);
        if ($id) {
            $query->where('adressId', '=', $adressId)->where('id', '=', $id)->update([$columnArr[0] => $name, $columnArr[1] => $comment, $columnArr[2] => $value]);
        } else {
            $query->insert([$columnArr[0] => $name, $columnArr[1] => $comment, $columnArr[2] => $value, 'adressId' => $adressId]);
        };
    }

    private function getColumnsNames($table)
    {
        switch ($table) {
            case 'montazh':
                $arr = ['name', 'comment', 'phone'];
                return $arr;
            case 'buildingMaterials':
                $arr = ['name', 'comment', 'summ'];
                return $arr;

            default:
                // code...
                break;
        }
    }

    public function addUpdateWorkerAdress(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $workerId = $data['workerId'];
        $name = $data['name'];
        $fullPrice = $data['fullPrice'];
        $comment = $data['comment'];
        $avanceValue = $data['avanceValue'];
        $date = $data['date'];
        if ($fullPrice != '0') {
            $workerAdressId = DB::table('workerAdress')->insertGetId(['name' => $name, 'fullPrice' => $fullPrice, 'workerId' => $workerId]);
        } else {
            $workerAdressId = DB::table('workerAdress')->where('workerId', '=', $workerId)->where('name', '=', $name)->value('id');
        }
        $this->addUpdateAvances($workerAdressId, $comment, $avanceValue, $date);
    }

    private function addUpdateAvances($adressId, $comment, $value, $date)
    {
        $id = DB::table('avances')->insertGetId(['workerAdressId' => $adressId, 'value' => $value, 'date' => $date, 'comment' => $comment]);
        return $id;
    }

    public function addAvanceForAdress(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $workerAdressId = $data['workerAdressId'];
        $comment = $data['comment'];
        $avanceValue = $data['avanceValue'];
        $date = $data['date'];
        if ($id) {
            DB::table('avances')->where('id', '=', $id)->update(['workerAdressId' => $workerAdressId, 'value' => $avanceValue, 'date' => $date, 'comment' => $comment]);
        } else {
            $this->addUpdateAvances($workerAdressId, $comment, $avanceValue, $date);
        }
    }

    public function addUpdateWorker(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];
        $name = $data['name'];
        $town = $data['town'];
        $workerId = '';
        $query = DB::table('worker');
        if ($id) {
            $query->where('id', '=', $id)->update(['name' => $name, 'town' => $town]);
        } else {
            $workerId = $query->insertGetId(['name' => $name, 'town' => $town]);
        };
        return $workerId;
    }

    public function addAcceptAndDisgard(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $accept = $data['accept'];
        if ($accept == 'true') {
            DB::table('acceptTable')->insert(['accountancyId' => $data['accountancyId'], 'userId' => Auth::user()->id]);
        } else {
            DB::table('disgardTable')->insert(['accountancyId' => $data['accountancyId'], 'userId' => Auth::user()->id, 'comment' => $data['comment']]);
        }
    }

    public function setHeadODSH(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $adressId = $data['adressId'];
        $entrance = $data['entrance'];
        $customer = $data['customer'];
        $size = $data['size'];
        $idODSH = DB::table('ODSH')->where('adressId', '=', $adressId)->where('entrance', '=', $entrance)->value('id');

        if ($idODSH) {
            DB::table('ODSH')->where('id', '=', $idODSH)->update(['customer' => $customer, 'sizeT' => $size]);
        } else {
            DB::table('ODSH')->insert(['entrance' => $entrance, 'adressId' => $adressId, 'customer' => $customer, 'sizeT' => $size]);
        }
    }

    private function createODSHHeadItem($adressId, $entrance)
    {
        $id = DB::table('ODSH')->insertGetId(['entrance' => $entrance, 'adressId' => $adressId]);
        return $id;
    }

    private function createODSHtableItem(
        $ODSHId,
        $level,
        $topEnter,
        $topN,
        $topV,
        $leftN,
        $leftV,
        $rightN,
        $rightV,
        $summ,
        $color,
    ) {
        DB::table('ODSHTable')->insert([
            'level' => $level,
            'topEnter' => $topEnter,
            'topN' => $topN,
            'topV' => $topV,
            'leftN' => $leftN,
            'leftV' => $leftV,
            'rightN' => $rightN,
            'rightV' => $rightV,
            'summ' => $summ,
            'color' => $color,
            'ODSHid' => $ODSHId
        ]);
    }

    public function setOdshTable(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $ODSHId = DB::table('ODSH')->where('adressId', '=', $data['adressId'])->where('entrance', '=', $data['entrance'])->value('id');
        if (!$ODSHId) {
            $ODSHId = $this->createODSHHeadItem($data['adressId'], $data['entrance']);
        }
        foreach ($data['objectArray'] as $value) {
            if ($value['id'] != '') {
                DB::table('ODSHTable')->where('id', '=', $value['id'])->update([
                    'level' => $value['level'],
                    'topEnter' => $value['topEnter'],
                    'topN' => $value['topN'],
                    'topV' => $value['topV'],
                    'leftN' => $value['leftN'],
                    'leftV' => $value['leftV'],
                    'rightN' => $value['rightN'],
                    'rightV' => $value['rightV'],
                    'summ' => $value['summ'],
                    'color' => $value['color'],
                ]);
            } else {
                $this->createODSHtableItem(
                    $ODSHId,
                    $value['level'],
                    $value['topEnter'],
                    $value['topN'],
                    $value['topV'],
                    $value['leftN'],
                    $value['leftV'],
                    $value['rightN'],
                    $value['rightV'],
                    $value['summ'],
                    $value['color'],
                );
            }
        }
    }
}
