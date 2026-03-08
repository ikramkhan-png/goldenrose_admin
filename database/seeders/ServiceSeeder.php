<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::updateOrCreate(
            ['slug' => 'machinery'],
            ['name' => 'Machinery', 'status' => 1]
        );

        Service::updateOrCreate(
            ['slug' => 'manpower'],
            ['name' => 'Manpower', 'status' => 1]
        );
    }
}
