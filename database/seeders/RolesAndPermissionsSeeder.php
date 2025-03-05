<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roleUser = Role::create(['name' => 'user']);
        $roleAdmin = Role::create(['name' => 'administrator']);

        // Assign roles to users
        $user = User::find(1);  // Assuming user with ID 1 is the admin
        $user->assignRole('administrator');
    }
}
