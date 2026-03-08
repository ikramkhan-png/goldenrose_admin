<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateClientRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-client-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create project_client and service_client roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating client roles...');

        // Get the permissions that clients need
        $viewClientDashboard = Permission::where('name', 'view_client_dashboard')->first();
        $sendMessages = Permission::where('name', 'send_messages')->first();

        // Create project_client role if it doesn't exist
        $projectClientRole = Role::firstOrCreate([
            'name' => 'project_client',
            'guard_name' => 'web',
        ]);

        if ($projectClientRole->wasRecentlyCreated) {
            $this->info('✓ Created project_client role');
        } else {
            $this->info('• project_client role already exists');
        }

        // Create service_client role if it doesn't exist
        $serviceClientRole = Role::firstOrCreate([
            'name' => 'service_client',
            'guard_name' => 'web',
        ]);

        if ($serviceClientRole->wasRecentlyCreated) {
            $this->info('✓ Created service_client role');
        } else {
            $this->info('• service_client role already exists');
        }

        // Assign permissions to both roles
        if ($viewClientDashboard) {
            $projectClientRole->syncPermissions([$viewClientDashboard]);
            $serviceClientRole->syncPermissions([$viewClientDashboard]);
            $this->info('✓ Assigned view_client_dashboard permission to both roles');
        }

        if ($sendMessages) {
            $projectClientRole->givePermissionTo($sendMessages);
            $serviceClientRole->givePermissionTo($sendMessages);
            $this->info('✓ Assigned send_messages permission to both roles');
        }

        $this->info('');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('✅ Client roles setup completed successfully!');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
