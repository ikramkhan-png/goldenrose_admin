<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:create 
                            {name : The name of the client}
                            {email : The email address}
                            {password : The password}
                            {type : The client type (service or project)}
                            {--phone= : Optional phone number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new client user with specified type (service or project)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $clientType = strtolower($this->argument('type'));
        $phone = $this->option('phone');

        // Validate client type
        if (!in_array($clientType, ['service', 'project'])) {
            $this->error('❌ Invalid client type. Must be either "service" or "project"');
            return 1;
        }

        // Check if email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('❌ A user with this email already exists!');
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'type' => 'client',
            'client_type' => $clientType,
            'phone' => $phone,
        ]);

        // Assign appropriate role
        $roleName = $clientType === 'service' ? 'client_service' : 'client_project';
        $role = Role::where('name', $roleName)->first();

        if ($role) {
            $user->assignRole($role);
        } else {
            $this->warn('⚠️  Role "' . $roleName . '" not found. Please run: php artisan db:seed --class=RolePermissionSeeder');
        }

        // Success message
        $this->info('');
        $this->info('✅ Client user created successfully!');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $user->name],
                ['Email', $user->email],
                ['Type', 'Client'],
                ['Client Type', ucfirst($user->client_type)],
                ['Phone', $user->phone ?? 'Not set'],
                ['Role', $roleName],
                ['Dashboard URL', '/client/dashboard'],
            ]
        );
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('');
        $this->info('🔐 Login Credentials:');
        $this->info('   Email: ' . $email);
        $this->info('   Password: ' . $password);
        $this->info('');

        return 0;
    }
}
