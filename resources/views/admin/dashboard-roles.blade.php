@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-600 mt-2">Welcome to the Golden Rose Admin Portal</p>
        </div>

        <!-- User Role Badge -->
        <div class="mb-8">
            <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                @if(auth()->user()->hasRole('super_admin'))
                    <span class="mr-2">👑</span> Super Admin - Full Access
                @elseif(auth()->user()->hasRole('admin'))
                    <span class="mr-2">⚙️</span> Admin - Limited Access
                @elseif(auth()->user()->hasRole('data_entry'))
                    <span class="mr-2">📝</span> Data Entry - Add Only
                @else
                    <span class="mr-2">👤</span> {{ auth()->user()->type ?? 'User' }}
                @endif
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm font-medium">Total Users</div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::count() }}</div>
                <div class="text-xs text-gray-500 mt-2">Registered users</div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm font-medium">Total Clients</div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::where('type', 'client')->count() }}</div>
                <div class="text-xs text-gray-500 mt-2">Service & Project</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm font-medium">Active Projects</div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Project::count() }}</div>
                <div class="text-xs text-gray-500 mt-2">Running projects</div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-gray-600 text-sm font-medium">Services</div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\ClientService::count() }}</div>
                <div class="text-xs text-gray-500 mt-2">Client services</div>
            </div>
        </div>

        <!-- Role Information Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                <h2 class="text-xl font-bold text-white">📋 Role-Based Access Information</h2>
            </div>
            <div class="px-6 py-6">
                <div class="space-y-6">
                    <!-- Super Admin -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900">👑 Super Admin</h3>
                        <p class="text-gray-600 mt-1">Full system access with all permissions</p>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            <li>✓ View and manage admin dashboard</li>
                            <li>✓ Manage all clients (service & project)</li>
                            <li>✓ Manage all services and projects</li>
                            <li>✓ Manage all billings and payments</li>
                            <li>✓ Manage users and employees</li>
                            <li>✓ Manage roles and permissions</li>
                            <li>✓ View reports and analytics</li>
                            <li>✓ Delete and export data</li>
                        </ul>
                    </div>

                    <!-- Admin (Sub Admin) -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900">⚙️ Admin (Sub Admin)</h3>
                        <p class="text-gray-600 mt-1">Almost full access except role management</p>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            <li>✓ View and manage admin dashboard</li>
                            <li>✓ Manage all clients, services, and projects</li>
                            <li>✓ Manage billings, users, and employees</li>
                            <li>✓ View reports and export data</li>
                            <li>✗ Cannot manage roles and permissions (critical)</li>
                        </ul>
                    </div>

                    <!-- Data Entry -->
                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900">📝 Data Entry</h3>
                        <p class="text-gray-600 mt-1">Can add data but cannot modify or delete</p>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            <li>✓ View admin dashboard</li>
                            <li>✓ Add clients, services, and projects</li>
                            <li>✓ View reports</li>
                            <li>✓ Export data</li>
                            <li>✗ Cannot modify or delete any data</li>
                            <li>✗ Cannot manage users or roles</li>
                            <li>ℹ️ Must contact admin for modifications</li>
                        </ul>
                    </div>

                    <!-- Client Service -->
                    <div class="border-l-4 border-orange-500 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900">🛎️ Client (Service Type)</h3>
                        <p class="text-gray-600 mt-1">View service dashboard and billing information</p>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            <li>✓ View assigned services</li>
                            <li>✓ View billing details (filterable by month)</li>
                            <li>✓ View payment history</li>
                            <li>✓ Send messages to support</li>
                            <li>✗ Cannot add or modify service data</li>
                        </ul>
                    </div>

                    <!-- Client Project -->
                    <div class="border-l-4 border-cyan-500 pl-4">
                        <h3 class="text-lg font-semibold text-gray-900">📊 Client (Project Type)</h3>
                        <p class="text-gray-600 mt-1">View project dashboard, finances, and documents</p>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            <li>✓ View assigned projects</li>
                            <li>✓ View budget and payment details</li>
                            <li>✓ View project documents and updates</li>
                            <li>✓ View billing information (filterable by month)</li>
                            <li>✓ Send messages to support</li>
                            <li>✗ Cannot add or modify project data</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">⚡ Quick Actions</h2>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @can('manage_clients')
                        <a href="{{ route('admin.clients.index') }}" class="px-4 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 font-medium text-center">
                            👥 Manage Clients
                        </a>
                    @endcan

                    @can('manage_projects')
                        <a href="{{ route('admin.projects.index') }}" class="px-4 py-3 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 font-medium text-center">
                            📁 Manage Projects
                        </a>
                    @endcan

                    @can('manage_services')
                        <a href="{{ route('admin.client-services.index') }}" class="px-4 py-3 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 font-medium text-center">
                            🛎️ Manage Services
                        </a>
                    @endcan

                    @can('manage_users')
                        <a href="{{ route('admin.roles.index') }}" class="px-4 py-3 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-200 font-medium text-center">
                            🔐 Manage Roles
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
