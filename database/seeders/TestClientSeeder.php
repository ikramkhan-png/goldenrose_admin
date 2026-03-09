<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestClientSeeder extends Seeder
{
    /**
     * Seed test client users for testing the client dashboard.
     */
    public function run(): void
    {
        // Create Service Client
        $serviceClient = User::firstOrCreate(
            ['email' => 'service@client.com'],
            [
                'name' => 'Service Client Demo',
                'password' => Hash::make('password'),
                'type' => 'client',
                'client_type' => 'service',
                'phone' => '+92 300 1234567',
            ]
        );

        // Assign service client role
        $serviceClientRole = Role::where('name', 'client_service')->first();
        if ($serviceClientRole && !$serviceClient->hasRole('client_service')) {
            $serviceClient->assignRole($serviceClientRole);
        }

        // Create Project Client
        $projectClient = User::firstOrCreate(
            ['email' => 'project@client.com'],
            [
                'name' => 'Project Client Demo',
                'password' => Hash::make('password'),
                'type' => 'client',
                'client_type' => 'project',
                'phone' => '+92 300 7654321',
            ]
        );

        // Assign project client role
        $projectClientRole = Role::where('name', 'client_project')->first();
        if ($projectClientRole && !$projectClient->hasRole('client_project')) {
            $projectClient->assignRole($projectClientRole);
        }

        $this->command->info('✅ Test clients created successfully!');
        $this->command->info('📧 Service Client: service@client.com | Password: password');
        $this->command->info('📧 Project Client: project@client.com | Password: password');
    }
}
