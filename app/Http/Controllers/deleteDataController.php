<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class deleteDataController extends Controller
{
    public function deleteManager(Request $request)
    {
        $id = $request->header('id');
        DB::table('users')->where('id', '=', $id)->update(['active' => false]);
    }

    public function deleteContract(Request $request)
    {
        $id = $request->header('id');
        DB::table('contract')->where('id', '=', $id)->delete();
    }

    public function deleteAdress(Request $request)
    {
        $id = $request->header('id');
        DB::table('adressData')->where('id', '=', $id)->delete();
    }
}
