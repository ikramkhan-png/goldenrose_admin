<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create role if it does not exist
        $role = Role::firstOrCreate([
            'name' => 'super_admin'
        ]);

        // Create user if it does not exist
        $user = User::firstOrCreate(
            ['email' => 'admin@goldenrose.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );

        // Assign role to user
        $user->assignRole($role);
    }
}