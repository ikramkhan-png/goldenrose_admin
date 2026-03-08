<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show user profile in admin layout
     */
    public function show(Request $request)
    {
        $user = auth()->user();
        
        // Load user roles
        if (method_exists($user, 'roles')) {
            $user->load('roles');
        }
        
        return view('admin.profile.show', [
            'user' => $user,
        ]);
    }
}
