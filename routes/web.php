<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdvanceController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ClientServiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\MachineryController;
use App\Http\Controllers\Admin\ManpowerController;
use App\Http\Controllers\Admin\OvertimeController;
use App\Http\Controllers\Admin\ProjectBillingController;
use App\Http\Controllers\Admin\ProjectDocumentController;
use App\Http\Controllers\Admin\ProjectServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\ClientDashboardController;
use App\Http\Controllers\Admin\ClientNoteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmployeeExpenseController;
use App\Http\Controllers\LanguageController;

// ========== INCLUDE AUTH ROUTES ==========
require __DIR__.'/auth.php';

// ========== DEBUG ROUTES (REMOVE AFTER TESTING) ==========
Route::get('/debug-auth', function () {
    return [
        'authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'user_email' => auth()->user()?->email ?? 'Not logged in',
        'user_type' => auth()->user()?->type ?? 'N/A',
        'session_id' => session()->getId(),
        'has_session' => session()->has('_token'),
        'intended_url' => session()->get('url.intended'),
        'login_route_exists' => \Illuminate\Support\Facades\Route::has('login'),
        'admin_dashboard_route_exists' => \Illuminate\Support\Facades\Route::has('admin.dashboard'),
    ];
});

Route::get('/test-login-page', function () {
    if (auth()->check()) {
        return 'You are logged in as: ' . auth()->user()->email;
    }
    return view('admin.layouts.guest', [
        'slot' => '<h1>TEST LOGIN PAGE - If you see this, routing works!</h1>'
    ]);
})->name('test.login');

Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login')->with('status', 'Force logged out! Session cleared.');
});

// ========== REDIRECT ROOT TO ADMIN OR LOGIN ==========
Route::get('/', function () {
    // Check authentication status
    if (auth()->check()) {
        $user = auth()->user();
        
        // Redirect based on user role
        try {
            if ($user->hasRole('client')) {
                return redirect()->route('client.dashboard');
            } elseif ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                return redirect()->route('admin.dashboard');
            }
        } catch (\Exception $e) {
            // Fallback to type field if role check fails
            if ($user->type === 'client') {
                return redirect()->route('client.dashboard');
            } elseif (in_array($user->type, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            }
        }
        
        // Default redirect for authenticated users
        return redirect()->route('admin.dashboard');
    }
    
    // Not authenticated - redirect to login
    return redirect()->route('login');
})->name('welcome');

// ========== SESSION TIMEOUT & UNAUTHENTICATED REDIRECT ==========
Route::middleware('web')->group(function () {
    // Protected routes for authenticated users
    Route::middleware('auth')->group(function () {
        Route::post('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'destroy'])->name('logout');
        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    });
});

// ========== LANGUAGE SWITCH ROUTE ==========
Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clients
    Route::resource('clients', ClientController::class);
    Route::get(
        'clients/{client}/projects-finance-summary',
        [ClientController::class, 'projectsFinanceSummary']
    )->name('clients.projectsFinanceSummary');

    // Client Services
    Route::resource('client-services', ClientServiceController::class);
    Route::get(
        'client-services/{client_service}/view',
        [ClientServiceController::class, 'view']
    )->name('client-services.view');

    // =========================
    // CLIENT LEVEL SERVICE BILLING
    // =========================

    // Add Billing
    Route::get(
        'client-services/{clientId}/add-client-billing',
        [ClientServiceController::class, 'createClientBilling']
    )->name('client-services.createClientBilling');

    Route::post(
        'client-services/{clientId}/store-client-billing',
        [ClientServiceController::class, 'storeClientBilling']
    )->name('client-services.storeClientBilling');

    // Finance Summary
    Route::get(
        'client-services/{clientId}/finance-summary',
        [ClientServiceController::class, 'financeSummary']
    )->name('client-services.financeSummary');

    // Edit Billing
    Route::get(
        'client-services/billing/{id}/edit',
        [ClientServiceController::class, 'editBilling']
    )->name('client-services.editBilling');

    // Update Billing (PUT)
    Route::match(['put', 'patch'], // allows both PUT & PATCH for flexibility
        'client-services/billing/{id}',
        [ClientServiceController::class, 'updateBilling']
    )->name('client-services.updateBilling');

    // Delete Billing
    Route::delete(
        'client-services/billing/{id}',
        [ClientServiceController::class, 'deleteBilling']
    )->name('client-services.deleteBilling');

    // Projects
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{project}/view', [ProjectController::class, 'view'])->name('projects.view');
    Route::get('projects/{project}/finance-summary', [ProjectController::class, 'financeSummary'])->name('projects.financeSummary');
    Route::get('projects/{project}/internal-show-from-client', [ProjectController::class, 'internalShowFromClient'])->name('projects.internalShowFromClient');
    Route::get('internal-details/show/{project}', [ProjectController::class, 'internalShow'])->name('internalDetails.show');

    // Project Documents
    Route::resource('project-documents', ProjectDocumentController::class);

    // Project Services
    Route::resource('project-services', ProjectServiceController::class);

    // Project Billings
    Route::get('project-billings/create', [ProjectBillingController::class, 'create'])->name('project-billings.create');
    Route::post('project-billings/store', [ProjectBillingController::class, 'store'])->name('project-billings.store');
    Route::put('project-billings/{billing}', [ProjectBillingController::class, 'update'])->name('project-billings.update');
    Route::delete('project-billings/{billing}', [ProjectBillingController::class, 'destroy'])->name('project-billings.destroy');
    Route::get('project-billings/{billing}/edit', [ProjectBillingController::class, 'edit'])->name('project-billings.edit');

    // Advances
    Route::resource('advances', AdvanceController::class);

    // Attendance
    Route::resource('attendance', AttendanceController::class);
    Route::post('attendance/bulk-store', [AttendanceController::class, 'bulkStore'])->name('attendance.bulk-store');

    // Employees
    Route::resource('employees', EmployeeController::class);

    // Departments
    Route::resource('departments', DepartmentController::class);

    // Project Expenses (for project internal costs)
    Route::resource('expenses', ExpenseController::class);

    // Employee Expenses (for salary calculations)
    Route::resource('employee-expenses', EmployeeExpenseController::class);

    // Machinery
    Route::resource('machinery', MachineryController::class);

    // Manpower
    Route::resource('manpower', ManpowerController::class);

    // Overtime
    Route::resource('overtimes', OvertimeController::class);

    // Roles
    Route::resource('roles', RoleController::class);

    // Users
    Route::resource('users', UserController::class);

    // Salaries
    Route::get('salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::post('salaries/export-pdf', [SalaryController::class, 'exportPdf'])->name('salaries.export-pdf');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/cache-clear', [SettingsController::class, 'clearCache'])->name('settings.clearCache');
    Route::post('settings/optimize', [SettingsController::class, 'optimize'])->name('settings.optimize');
    Route::post('settings/backup', [SettingsController::class, 'backup'])->name('settings.backup');
    Route::post('settings/test-email', [SettingsController::class, 'testEmail'])->name('settings.testEmail');

    // Client Notes & Queries (Admin side)
    Route::post('client-notes', [ClientNoteController::class, 'store'])->name('client-notes.store');
    Route::delete('client-notes/{id}', [ClientNoteController::class, 'destroy'])->name('client-notes.destroy');
    Route::post('client-queries/{id}/reply', [ClientNoteController::class, 'replyToQuery'])->name('client-queries.reply');
});

// --------- CLIENT ROUTES (Service & Project Clients) ---------
Route::prefix('client')->name('client.')->middleware(['auth', 'client'])->group(function () {
    Route::get('dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('project/{id}', [ClientDashboardController::class, 'showProject'])->name('project.show');
    Route::post('query', [ClientDashboardController::class, 'storeQuery'])->name('query.store');
    Route::post('note/{id}/read', [ClientDashboardController::class, 'markNoteRead'])->name('note.read');
});

// ========== CATCH-ALL FALLBACK ==========
// Redirect any undefined routes to login if not authenticated, or dashboard if authenticated
Route::fallback(function () {
    if (auth()->check()) {
        $user = auth()->user();
        
        // Redirect based on user type
        try {
            if ($user->hasRole('client')) {
                return redirect()->route('client.dashboard');
            }
        } catch (\Exception $e) {
            if ($user->type === 'client') {
                return redirect()->route('client.dashboard');
            }
        }
        
        // Default to admin dashboard for authenticated users
        return redirect()->route('admin.dashboard');
    }
    
    // Not authenticated - redirect to login
    return redirect()->route('login')->with('error', 'The page you requested was not found. Please login to continue.');
});