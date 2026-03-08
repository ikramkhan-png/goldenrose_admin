<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VerifyRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verify-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify roles and permissions setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verifying Multi-Client Dashboard System Setup');
        $this->newLine();

        // Check Roles
        $roles = Role::all();
        $this->info("✅ Roles Created: {$roles->count()}");
        foreach ($roles as $r) {
            $this->line("   - {$r->name}");
        }

        // Check Permissions
        $permissions = Permission::all();
        $this->newLine();
        $this->info("✅ Permissions Created: {$permissions->count()}");
        foreach ($permissions as $p) {
            $this->line("   - {$p->name}");
        }

        // Check Role-Permission Mapping
        $this->newLine();
        $this->info("✅ Role-Permission Mapping:");
        foreach ($roles as $role) {
            $count = $role->permissions->count();
            $this->line("   - {$role->name}: {$count} permissions");
        }

        $this->newLine();
        $this->info("✅ Setup verification complete!");
        $this->info("   Next: Assign roles to users");

        return 0;
    }
}
