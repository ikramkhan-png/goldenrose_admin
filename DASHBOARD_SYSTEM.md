# Multi-Client Dashboard System - Implementation Guide

## 📋 Overview

This system implements a professional role-based access control (RBAC) dashboard for managing three main user types:
1. **Admin Users** (Super Admin, Admin, Data Entry)
2. **Service Clients** 
3. **Project Clients**

Each user type has their own specialized dashboard and permissions.

---

## 🎯 User Roles & Permissions

### 1. **Super Admin** (👑)
- **Full system access** with all permissions
- Can manage all aspects of the system
- Can assign and manage roles and permissions
- **Route:** `/admin/dashboard`

**Permissions:**
- ✓ View admin dashboard
- ✓ Manage all clients
- ✓ Manage services & projects
- ✓ Manage billings
- ✓ Manage users & employees
- ✓ Manage roles & permissions
- ✓ View reports & analytics
- ✓ Delete & export data

### 2. **Admin/Sub Admin** (⚙️)
- Almost full access except **one critical restriction**: Cannot manage roles and permissions
- Can manage clients, services, projects, and employees
- **Route:** `/admin/dashboard`

**Permissions:**
- ✓ View admin dashboard
- ✓ Manage clients, services, projects
- ✓ Manage billings & payments
- ✓ Manage users & employees
- ✓ View reports & analytics
- ✓ Export data
- ✗ **Cannot manage roles** (critical restriction)

### 3. **Data Entry** (📝)
- Can ADD new data only
- Cannot modify or delete existing data
- Must contact admin for modifications
- **Route:** `/admin/dashboard`

**Permissions:**
- ✓ View admin dashboard
- ✓ Add clients, services, projects
- ✓ View reports
- ✓ Export data
- ✗ Cannot modify existing data
- ✗ Cannot delete data
- ✗ Cannot manage users or roles

### 4. **Client - Service Type** (🛎️)
- View assigned services and billing information
- Monthly filterable finance overview
- Can send support messages
- **Route:** `/client/dashboard`

**Features:**
- View all assigned services
- See detailed billing records (rate, days, amount)
- Filter billing by month
- Total finance overview (monthly)
- Support messaging system

### 5. **Client - Project Type** (📊)
- View assigned projects and financial status
- Monthly filterable project billing
- Access to project documents and progress updates
- Can send support messages
- **Route:** `/client/dashboard`

**Features:**
- View project budget vs. paid amount
- See remaining balance
- View progress and payment percentage
- Access project documents
- Filter billing by month
- Support messaging system

---

## 🗄️ Database Structure

### Roles Table
```
roles
- id
- name
- guard_name
- created_at
- updated_at
```

### Permissions Table
```
permissions
- id
- name
- guard_name
- created_at
- updated_at
```

### Model-Role Relations
```
model_has_roles
- role_id
- model_type
- model_id

model_has_permissions
- permission_id
- model_type
- model_id

role_has_permissions
- permission_id
- role_id
```

---

## 🔧 Setup Instructions

### 1. Database Setup
The system uses migrations to create necessary tables:

```bash
# Run migrations (includes permission tables)
php artisan migrate
```

This creates:
- `permissions` table
- `roles` table
- `model_has_permissions` table
- `model_has_roles` table
- `role_has_permissions` table

### 2. Seed Roles & Permissions
```bash
# Seed roles and permissions
php artisan db:seed --class=RolePermissionSeeder
```

This creates:
- **Roles:** super_admin, admin, data_entry, client_service, client_project, employee
- **Permissions:** 13 permissions for managing different features

### 3. Assign Roles to Users

**Via Artisan Tinker:**
```bash
php artisan tinker

# Assign Super Admin role
$user = User::find(1);
$user->assignRole('super_admin');

# Assign Admin role
$user->assignRole('admin');

# Assign Data Entry role
$user->assignRole('data_entry');

# Assign Client roles
$user->assignRole('client_service'); // for service clients
$user->assignRole('client_project'); // for project clients
```

**Or Update User Model:**
```php
// In routes or controller
auth()->user()->assignRole('super_admin');
auth()->user()->syncRoles(['admin']); // single role
auth()->user()->syncRoles(['admin', 'client_service']); // multiple roles
```

---

## 🛣️ Routing Structure

### Admin Routes
All admin routes are prefixed with `/admin` and require authentication:

```php
// Admin Dashboard
GET /admin/dashboard

// Resource Management
GET|POST /admin/clients
GET|POST /admin/projects
GET|POST /admin/client-services
GET|POST /admin/project-billings
GET|POST /admin/roles
// ... and more

```

### Client Routes
Client routes are prefixed with `/client` and require client middleware:

```php
// Service/Project Client Dashboard
GET /client/dashboard?month=2026-03

// Response depends on client_type:
// - Service clients: See service-dashboard.blade.php
// - Project clients: See project-dashboard.blade.php
```

### Middleware
**Location:** `app/Http/Middleware/ClientMiddleware.php`

This middleware:
- Checks if user is authenticated
- Verifies user type is 'client'
- Verifies client_type is either 'service' or 'project'

---

## 🛡️ Authorization Checks

### Using Roles
```php
// In blade templates
@if(auth()->user()->hasRole('super_admin'))
    <!-- Content for super admin only -->
@endif

// In controller
if (auth()->user()->hasRole('admin')) {
    // Do something
}
```

### Using Permissions
```php
// In blade templates
@can('manage_clients')
    <a href="{{ route('admin.clients.index') }}">Manage Clients</a>
@endcan

// In controller
if (auth()->user()->can('manage_projects')) {
    // Do something
}

// In routes (middleware)
Route::get('/projects', [ProjectController::class, 'index'])
    ->middleware('can:manage_projects');
```

---

## 🎨 Client Dashboards

### Service Client Dashboard
**Route:** `GET /client/dashboard` (for users with client_type='service')

**Features:**
1. **Finance Overview** (top section)
   - Total billing amount for selected month
   - Services count
   - Billing records count

2. **Services Details** (main section)
   - Service name and description
   - Total amount billed for this service
   - Detailed billing table:
     - Date
     - Rate
     - Days
     - Amount

3. **Month Filter**
   - Filter results by year-month
   - Updates all data accordingly

4. **Support Section**
   - Email contact
   - Send message button (placeholder for future implementation)

### Project Client Dashboard
**Route:** `GET /client/dashboard` (for users with client_type='project')

**Features:**
1. **Overall Finance Information** (top section)
   - Total Budget (all projects)
   - Total Paid (all projects)
   - Total Remaining (all projects)
   - Active projects count

2. **Project Details** (per project)
   - Project name & description
   - Finance details:
     - Budget
     - Paid amount
     - Remaining balance
     - Progress percentage
   - Progress bar visualization

3. **Billing Information** (monthly)
   - Dates and amounts
   - Filter by month
   - Detailed billing records

4. **Project Documents**
   - Uploaded documentation
   - Progress updates
   - Upload dates
   - Document download links

5. **Support Section**
   - Email contact
   - Send message button

---

## 📝 Controllers

### ClientDashboardController
**Location:** `app/Http/Controllers/Admin/ClientDashboardController.php`

**Methods:**
- `index()` - Route all dashboard requests to appropriate dashboard
- `serviceClientDashboard()` - Handle service client dashboard
- `projectClientDashboard()` - Handle project client dashboard
- `getMonthDateRange()` - Helper to parse month filter

---

## 🎨 Views

### Admin Dashboard
- **Location:** `resources/views/admin/dashboard-roles.blade.php`
- Shows role information and permissions
- Quick access buttons based on user permissions

### Service Client Dashboard
- **Location:** `resources/views/client/dashboard/service-dashboard.blade.php`
- Total billing overview
- Services with billing details
- Month filter

### Project Client Dashboard
- **Location:** `resources/views/client/dashboard/project-dashboard.blade.php`
- Finance summary (budget, paid, remaining)
- Project-wise details
- Documents section
- Month filter

---

## 🔄 Assigning Client Types to Users

When creating users in the system, set the `client_type` field:

```php
// Service Client
User::create([
    'name' => 'Service Client Name',
    'email' => 'service@example.com',
    'password' => bcrypt('password'),
    'type' => 'client',
    'client_type' => 'service', // ← Important
    'phone' => '1234567890'
]);

// Project Client
User::create([
    'name' => 'Project Client Name',
    'email' => 'project@example.com',
    'password' => bcrypt('password'),
    'type' => 'client',
    'client_type' => 'project', // ← Important
    'phone' => '0987654321'
]);
```

---

## 📊 Available Permissions

```php
1. view_admin_dashboard       // View admin dashboard
2. manage_clients             // Create/edit/delete clients
3. manage_services            // Create/edit/delete services
4. manage_projects            // Create/edit/delete projects
5. manage_billings            // Create/edit/delete billings
6. manage_users               // Create/edit/delete users
7. manage_employees           // Create/edit/delete employees
8. manage_roles               // Create/edit/delete roles (critical)
9. view_reports               // View analytical reports
10. delete_data               // Delete system data
11. export_data               // Export data to files
12. view_client_dashboard     // Access client dashboard
13. send_messages             // Send messages/support tickets
```

---

## 💡 Usage Examples

### Example 1: Assign Super Admin
```php
// In controller or job
$user = User::find(1);
$user->assignRole('super_admin');
// User now has access to: /admin/dashboard with full permissions
```

### Example 2: Assign Sub Admin
```php
$user = User::find(2);
$user->assignRole('admin');
// User can manage everything except roles
```

### Example 3: Assign Data Entry
```php
$user = User::find(3);
$user->assignRole('data_entry');
// User can only add data, view dashboard, export
```

### Example 4: Assign Service Client
```php
$user = User::find(4);
$user->assignRole('client_service');
// User gets redirected to /client/dashboard
// Sees service billing information
```

### Example 5: Assign Project Client
```php
$user = User::find(5);
$user->assignRole('client_project');
// User gets redirected to /client/dashboard
// Sees project finance and documents
```

---

## 🚀 Frontend Components

### Service Dashboard Components
- Month filter
- Finance overview cards
- Services billing table
- Support contact section

### Project Dashboard Components
- Month filter
- Finance overview cards (budget, paid, remaining)
- Project details section
- Billing table
- Documents section
- Support contact section

---

## 🔐 Security Notes

1. **Middleware Protection:** Client routes are protected by `ClientMiddleware`
2. **Authorization:** Use `@can` and `@cannot` directives in views
3. **Role Checking:** Use `hasRole()` and `hasPermission()` methods
4. **Critical Feature:** Role management is restricted to Super Admin only
5. **Data Modification:** Data Entry users cannot modify or delete data

---

## 📞 Support & Messages Feature

Both dashboards have support sections with:
- Email contact button (links to mailto)
- Send Message button (placeholder for future implementation)

**To implement messaging:**
1. Create `Message` model
2. Add message routes
3. Implement message controller
4. Create message view/modal

---

## 🎓 Best Practices

1. **Always assign roles to users** during registration or user creation
2. **Use permissions in controllers** for fine-grained control
3. **Check roles in blade templates** for UI visibility
4. **Audit role changes** - log when roles are assigned/revoked
5. **Keep Super Admin count low** - restrict who becomes super admin
6. **Use seeder for initial setup** - makes onboarding consistent

---

## 📚 Additional Resources

- **Spatie Laravel Permission Documentation:** https://spatie.be/docs/laravel-permission
- **Laravel Authorization:** https://laravel.com/docs/authorization
- **Laravel Middleware:** https://laravel.com/docs/middleware

---

## 🆘 Troubleshooting

### Issue: User cannot access client dashboard
**Solution:** Check that user has:
- `type` = 'client'
- `client_type` = 'service' or 'project'
- Assigned correct role

### Issue: Permissions not working
**Solution:** 
1. Clear config cache: `php artisan config:clear`
2. Clear cache: `php artisan cache:clear`
3. Re-seed permissions: `php artisan db:seed --class=RolePermissionSeeder`

### Issue: Roles not loading
**Solution:**
1. Check user middleware is registered
2. Ensure spatie/laravel-permission is installed
3. Check migrations are run: `php artisan migrate:status`

---

**Last Updated:** March 6, 2026  
**Version:** 1.0  
**Status:** Production Ready
