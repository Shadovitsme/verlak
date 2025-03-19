<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class deleteDataController extends Controller
{
    public function decodeData($request)
    {
        return json_decode($request->getContent(), true);
    }

    public function deleteManager(Request $request)
    {
        $data = $this->decodeData($request);
        $id = $data['id'];
        DB::table('users')->where('id', '=', $id)->update(['active' => false]);
    }

    public function universalDelete(Request $request)
    {
        $data = $this->decodeData($request);
        $id = $data['id'];
        $where = $data['where'];
        DB::table($where)->where('id', '=', $id)->delete();
    }

    public function deleteEntrance(Request $request)
    {
        $data = $this->decodeData($request);
        $name = $data['id'];
        DB::table('elevator')->where('entrance', '=', $name)->delete();
    }

    public function deleteElevator(Request $request)
    {
        $data = $this->decodeData($request);
        $name = $data['name'];
        $adressId = $data['adressId'];
        $entrance = $data['entrance'];
        DB::table('elevator')->where('entrance', '=', $entrance)->where('adressId', '=', $adressId)->where('name', '=', $name)->delete();
    }

    public function deleteBuildingData(Request $request)
    {
        $data = $this->decodeData($request);
        $id = $data['id'];
        $name = $data['where'];
        DB::table('building')->where('adressId', '=', $name)->where('name', '=', $id)->delete();
    }
}
