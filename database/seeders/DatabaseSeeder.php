<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolePermissionSeeder::class);
        
        // Seed test client users
        $this->call(TestClientSeeder::class);
        
        // Other seeders
        // $this->call(EmployeeSeeder::class);
        // $this->call(ServiceSeeder::class);
         $this->call([
        SuperAdminSeeder::class,
    ]);
    }
   
}