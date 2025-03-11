<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class setDataController extends Controller
{
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
