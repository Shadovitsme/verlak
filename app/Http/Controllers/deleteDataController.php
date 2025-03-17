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

    public function universalDelete(Request $request)
    {
        $id = $request->header('id');
        $where = $request->header('where');
        DB::table($where)->where('id', '=', $id)->delete();
    }

    public function deleteEntrance(Request $request)
    {
        $name = $request->header('id');
        DB::table('elevator')->where('entrance', '=', $name)->delete();
    }
}
