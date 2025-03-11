<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class deleteDataController extends Controller
{
    public function deleteManager(Request $request)
    {
        $id = $request->header('id');
        DB::table('users')->where('id', '=', $id)->update(['active'=> false]);
    }
}
