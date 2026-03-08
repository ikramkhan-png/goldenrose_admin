<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of roles and permissions.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        // Transform name first for validation
        $roleName = strtolower(str_replace(' ', '_', $request->name));
        
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        // Check if role already exists with the transformed name
        if (Role::where('name', $roleName)->exists()) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Role '{$roleName}' already exists.");
        }

        try {
            $role = Role::create([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            // Sync permissions if provided and are valid IDs
            if ($request->has('permissions') && !empty($request->permissions)) {
                $permissionIds = array_filter($request->permissions, 'is_numeric');
                if (!empty($permissionIds)) {
                    $permissions = Permission::whereIn('id', $permissionIds)->get();
                    $role->syncPermissions($permissions);
                }
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Transform name for validation
        $roleName = strtolower(str_replace(' ', '_', $request->name));
        
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        // Check if another role already exists with this transformed name
        if ($roleName !== $role->name && Role::where('name', $roleName)->exists()) {
            return redirect()->route('admin.roles.index')
                ->with('error', "Role '{$roleName}' already exists.");
        }

        try {
            $role->update([
                'name' => $roleName,
            ]);

            // Sync permissions if provided
            if ($request->has('permissions') && !empty($request->permissions)) {
                $permissionIds = array_filter($request->permissions, 'is_numeric');
                if (!empty($permissionIds)) {
                    $permissions = Permission::whereIn('id', $permissionIds)->get();
                    $role->syncPermissions($permissions);
                } else {
                    $role->syncPermissions([]);
                }
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('admin.roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of super_admin and system roles
        if (in_array($role->name, ['super_admin', 'admin'])) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete system roles.');
        }

        // Check if role is assigned to users
        if ($role->users()->exists()) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role that is assigned to users.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
