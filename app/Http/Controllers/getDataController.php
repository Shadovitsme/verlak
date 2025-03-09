<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class getDataController extends Controller
{
    public function getAllManagers()
    {
        $managers = DB::table('users')->get();
        foreach ($managers as $manager) {
            echo $manager->name . '<br>';
        }
    }
}
