<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|in:admin,client,employee',
            'client_type' => 'nullable|in:service,project',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,id',
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => $validated['type'],
            'client_type' => $validated['type'] === 'client' ? $validated['client_type'] : null,
            'phone' => $validated['phone'],
        ]);

        // Assign role
        $role = Role::find($validated['role']);
        $user->assignRole($role);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User created successfully and assigned to ' . $role->name . ' role.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->first();
        
        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'type' => 'required|in:admin,client,employee',
            'client_type' => 'nullable|in:service,project',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,id',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => $validated['type'],
            'client_type' => $validated['type'] === 'client' ? $validated['client_type'] : null,
            'phone' => $validated['phone'],
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Update role
        $role = Role::find($validated['role']);
        $user->syncRoles($role);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Protect the current authenticated user
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Protect super_admin users
        if ($user->hasRole('super_admin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete super_admin users.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
