# Quick Reference Guide - Client Dashboard System

## 🚀 Quick Setup Commands

### Initial Setup
```bash
# Install dependencies
composer install

# Run migrations
php artisan migrate

# Seed roles and permissions
php artisan db:seed --class=RolePermissionSeeder

# 🎉 System ready!
```

---

## 👤 Assigning Roles (Artisan Tinker)

```bash
php artisan tinker
```

### For Admin Users
```php
// Super Admin
$user = User::find(1);
$user->assignRole('super_admin');
exit

// Sub Admin
$user = User::find(2);
$user->assignRole('admin');
exit

// Data Entry
$user = User::find(3);
$user->assignRole('data_entry');
exit
```

### For Client Users
```php
// Service Client
$client = User::find(4);
$client->client_type = 'service';
$client->type = 'client';
$client->assignRole('client_service');
$client->save();
exit

// Project Client
$client = User::find(5);
$client->client_type = 'project';
$client->type = 'client';
$client->assignRole('client_project');
$client->save();
exit
```

---

## 📝 Quick Database Queries

### Check User Roles
```sql
SELECT u.name, r.name as role 
FROM users u
JOIN model_has_roles mhr ON u.id = mhr.model_id
JOIN roles r ON mhr.role_id = r.id
WHERE mhr.model_type = 'App\\Models\\User';
```

### Check User Permissions
```sql
SELECT u.name, p.name as permission
FROM users u
JOIN model_has_permissions mhp ON u.id = mhp.model_id
JOIN permissions p ON mhp.permission_id = p.id
WHERE mhp.model_type = 'App\\Models\\User';
```

---

## 🔗 Important Routes

### Admin Routes (Requires Authentication)
- Dashboard: `/admin/dashboard`
- Clients: `/admin/clients`
- Projects: `/admin/projects`
- Services: `/admin/client-services`
- Billings: `/admin/project-billings`
- Roles: `/admin/roles`

### Client Routes (Requires Client Middleware)
- Dashboard: `/client/dashboard`
- Dashboard with filter: `/client/dashboard?month=2026-03`

---

## 🎯 Role-Based Dashboard Access

| User Type | Dashboard URL | View |
|-----------|---------------|------|
| Super Admin | `/admin/dashboard` | dashboard-roles.blade.php |
| Admin | `/admin/dashboard` | dashboard-roles.blade.php |
| Data Entry | `/admin/dashboard` | dashboard-roles.blade.php |
| Service Client | `/client/dashboard` | service-dashboard.blade.php |
| Project Client | `/client/dashboard` | project-dashboard.blade.php |

---

## 💻 Working in Code

### Check User Role
```php
// Single role
if (auth()->user()->hasRole('super_admin')) {
    // Super admin only
}

// Multiple roles
if (auth()->user()->hasAnyRole('super_admin', 'admin')) {
    // Super admin or admin
}
```

### Check User Permission
```php
// Single permission
if (auth()->user()->can('manage_clients')) {
    // Can manage clients
}

// In blade
@can('manage_clients')
    <!-- Show button -->
@endcan
```

### Check Client Type
```php
if (auth()->user()->client_type === 'service') {
    // Service client
}

if (auth()->user()->client_type === 'project') {
    // Project client
}
```

---

## 📊 Available Roles

```
- super_admin      (Full access, can manage roles)
- admin            (Full access except roles)
- data_entry       (Add only, no modify/delete)
- client_service   (View service dashboard)
- client_project   (View project dashboard)
- employee         (View dashboard only)
```

---

## 🔐 Available Permissions

```
- view_admin_dashboard
- manage_clients
- manage_services
- manage_projects
- manage_billings
- manage_users
- manage_employees
- manage_roles
- view_reports
- delete_data
- export_data
- view_client_dashboard
- send_messages
```

---

## 🐛 Debugging

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Check Migrations
```bash
php artisan migrate:status
```

### Re-seed Roles
```bash
php artisan db:seed --class=RolePermissionSeeder
```

### Test Role Assignment
```bash
php artisan tinker
$user = User::first();
dd($user->getRoleNames());
dd($user->getPermissionNames());
```

---

## 🎨 Key Files Location

```
app/
  ├── Http/
  │   ├── Controllers/
  │   │   └── Admin/
  │   │       └── ClientDashboardController.php
  │   └── Middleware/
  │       └── ClientMiddleware.php
  └── Models/
      └── User.php (updated with HasRoles trait)

routes/
  └── web.php (updated with client routes)

resources/views/
  ├── admin/
  │   └── dashboard-roles.blade.php
  └── client/dashboard/
      ├── service-dashboard.blade.php
      └── project-dashboard.blade.php

database/seeders/
  ├── DatabaseSeeder.php
  └── RolePermissionSeeder.php

bootstrap/
  └── app.php (middleware registration)
```

---

## 📱 Client Dashboard Features

### Service Client Dashboard
- ✓ Month-based filtering
- ✓ Total billing overview
- ✓ Services list with billing details
- ✓ Rate, days, and amount breakdown
- ✓ Support message button

### Project Client Dashboard
- ✓ Month-based filtering
- ✓ Finance overview (Budget, Paid, Remaining)
- ✓ Projects list with financial details
- ✓ Progress percentage visualization
- ✓ Billing records per month
- ✓ Project documents section
- ✓ Support message button

---

## ✅ Testing Checklist

- [ ] Roles seeded successfully
- [ ] Super Admin can access `/admin/dashboard`
- [ ] Admin can access `/admin/dashboard` but not role management
- [ ] Data Entry can add data but not delete
- [ ] Service Client can access `/client/dashboard` with service view
- [ ] Project Client can access `/client/dashboard` with project view
- [ ] Month filter working on both dashboards
- [ ] Billing details displaying correctly
- [ ] Project documents displaying correctly
- [ ] Support buttons present on all client dashboards

---

## 🚨 Important Notes

1. **First Time Setup:** Always run both migrate and seed commands
2. **User Creation:** Remember to set `type='client'` and `client_type='service'|'project'`
3. **Role Assignment:** Roles must be assigned to users after creation
4. **Cache Issues:** Clear cache if roles/permissions not working
5. **Critical Role:** Only Super Admin can manage roles
6. **Client Type:** Required field for client dashboard routing

---

## 📞 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| User can't access dashboard | Check user role and middleware |
| Permissions not working | Clear cache, re-seed |
| Dashboard blank | Check role in database |
| Client routed wrong dashboard | Verify client_type field value |
| 403 Forbidden on client route | User might not be 'client' type |

---

**Last Updated:** March 6, 2026  
**Quick Reference v1.0**
