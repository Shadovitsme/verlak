<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class setDataController extends Controller
{
    public function addNewContract(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $userId = Auth::user()->id;
        DB::table('contract')->insert([
            'contractNumber' => $data['contractNumber'],
            'date' => $data['date'],
            'town' => ($data['town']),
            'organization' => $data['organization'],
            'state' => $data['state'],
            'manager' => $userId,
        ]);
        echo ('success');
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
