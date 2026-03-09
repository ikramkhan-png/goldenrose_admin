<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckClientUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:check {email : The email address to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check client user configuration and troubleshoot issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('❌ User not found with email: ' . $email);
            return 1;
        }

        $this->info('');
        $this->info('🔍 User Information Check');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        // Basic Info
        $this->table(
            ['Field', 'Value', 'Status'],
            [
                ['ID', $user->id, '✓'],
                ['Name', $user->name, '✓'],
                ['Email', $user->email, '✓'],
                ['Type', $user->type ?? 'NOT SET', $user->type === 'client' ? '✅ Correct' : '❌ Should be "client"'],
                ['Client Type', $user->client_type ?? 'NOT SET', in_array($user->client_type, ['service', 'project']) ? '✅ Valid' : '❌ Should be "service" or "project"'],
                ['Phone', $user->phone ?? 'Not set', '-'],
            ]
        );

        // Roles Check
        $this->info('');
        $this->info('🎭 Roles & Permissions:');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        $roles = $user->roles;
        if ($roles->count() > 0) {
            foreach ($roles as $role) {
                $expectedRole = $user->client_type === 'service' ? 'client_service' : 'client_project';
                $status = $role->name === $expectedRole ? '✅ Correct' : '⚠️  Expected: ' . $expectedRole;
                $this->line('  Role: ' . $role->name . ' ' . $status);
                
                $permissions = $role->permissions;
                if ($permissions->count() > 0) {
                    foreach ($permissions as $permission) {
                        $this->line('    ├─ Permission: ' . $permission->name);
                    }
                }
            }
        } else {
            $this->warn('  ❌ No roles assigned!');
            $this->info('  💡 Fix: Run php artisan db:seed --class=RolePermissionSeeder');
        }

        // Dashboard Access Check
        $this->info('');
        $this->info('🚪 Dashboard Access Check:');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        $canAccessDashboard = $user->type === 'client' 
            && in_array($user->client_type, ['service', 'project'])
            && $roles->count() > 0;
        
        if ($canAccessDashboard) {
            $this->info('  ✅ User CAN access client dashboard');
            $this->info('  🌐 Dashboard URL: /client/dashboard');
        } else {
            $this->error('  ❌ User CANNOT access client dashboard');
            $this->info('');
            $this->info('  🔧 Issues Found:');
            if ($user->type !== 'client') {
                $this->line('     - Type must be "client" (current: ' . ($user->type ?? 'null') . ')');
            }
            if (!in_array($user->client_type, ['service', 'project'])) {
                $this->line('     - Client type must be "service" or "project" (current: ' . ($user->client_type ?? 'null') . ')');
            }
            if ($roles->count() === 0) {
                $this->line('     - No roles assigned');
            }
        }

        // Suggested Fixes
        if (!$canAccessDashboard) {
            $this->info('');
            $this->info('💡 Suggested Fixes:');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            
            if ($user->type !== 'client') {
                $this->line('  1. Update user type:');
                $this->line('     php artisan tinker');
                $this->line('     $user = User::find(' . $user->id . ');');
                $this->line('     $user->type = "client";');
                $this->line('     $user->save();');
                $this->line('');
            }
            
            if (!in_array($user->client_type, ['service', 'project'])) {
                $this->line('  2. Set client type:');
                $this->line('     php artisan tinker');
                $this->line('     $user = User::find(' . $user->id . ');');
                $this->line('     $user->client_type = "service"; // or "project"');
                $this->line('     $user->save();');
                $this->line('');
            }
            
            if ($roles->count() === 0) {
                $this->line('  3. Assign role:');
                $this->line('     php artisan tinker');
                $this->line('     $user = User::find(' . $user->id . ');');
                $this->line('     $user->assignRole("client_service"); // or "client_project"');
                $this->line('');
            }

            $this->line('  Or delete and recreate:');
            $this->line('     php artisan client:create "Name" "email@example.com" "password" service');
        }

        $this->info('');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        return 0;
    }
}
