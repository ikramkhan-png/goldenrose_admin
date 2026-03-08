# 🚀 User & Role Setup Guide

## ⚡ Quick Setup Steps (5 minutes)

### Step 1: Clear Cache
Run these commands in your terminal:

```bash
php artisan cache:clear
php artisan route:cache
php artisan config:cache
```

### Step 2: Create Client Roles
Create the two client roles (project_client and service_client):

```bash
php artisan app:create-client-roles
```

**Expected Output:**
```
✓ Created project_client role
✓ Created service_client role
✓ Assigned view_client_dashboard permission to both roles
✓ Assigned send_messages permission to both roles

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ Client roles setup completed successfully!
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

### Step 3: Verify Setup
```bash
php artisan app:verify-roles
```

You should see all 8 roles now (6 original + 2 new client roles).

---

## 📖 How to Create Users

You now have **3 ways** to create users:

### 🔹 Method 1: Client Registration (Self-Service) ← **RECOMMENDED FOR CLIENTS**
**URL:** `/register`  
**Features:**
- ✅ Clients create their own account
- ✅ Select "Services" or "Projects"
- ✅ Automatically assigned correct role (service_client or project_client)
- ✅ Redirects to client dashboard after registration

**Flow:**
```
Client visits /register 
→ Fills: Name, Email, Phone, Password
→ Selects: "Services" or "Projects"
→ Creates account
→ Role assigned automatically
→ Sees: Client Dashboard (Services or Projects based on selection)
```

### 🔹 Method 2: Admin User Management ← **FOR ADMINS & SUPER ADMINS**
**URL:** `/admin/users/create`  
**Access:** Super Admin only → System → Users Management → Create New User  
**Features:**
- ✅ Create admin users
- ✅ Create employees
- ✅ Manually create client accounts (if needed)
- ✅ Assign any role
- ✅ Set password directly

**Fields:**
- Name, Email, Phone
- User Type: admin / client / employee
- Client Type: service / project (only if type=client)
- Password (required)
- Role Assignment

### 🔹 Method 3: Database - Tinker (Quick Testing)
```bash
php artisan tinker

# Create Super Admin
$user = User::create([
    'name' => 'Admin Name',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'type' => 'admin',
    'phone' => '1234567890'
]);
$user->assignRole('super_admin');

# Create Project Client
$user = User::create([
    'name' => 'Client Name',
    'email' => 'client@example.com',
    'password' => bcrypt('password'),
    'type' => 'client',
    'client_type' => 'project',
    'phone' => '1234567890'
]);
$user->assignRole('project_client');

exit
```

---

## 👥 User Creation Flow by Type

### For Clients (Self-Service via Registration)
```
/register
↓
Select "Services" or "Projects"
↓
Account Created
↓
Role auto-assigned:
  - Services → service_client role
  - Projects → project_client role
↓
Dashboard loads (client dashboard)
```

### For Admins/Employees (Via Admin Panel)
```
/admin/users/create
↓
Fill form with all details
↓
Select User Type: admin/client/employee
↓
Select Role to assign
↓
User Created
↓
Dashboard loads (admin dashboard if admin)
```

---

## 🎯 Quick Access Links

### For Clients:
- **Register:** `http://localhost/register`
- **Login:** `http://localhost/login`
- **Dashboard:** `http://localhost/client/dashboard` (auto after login)

### For Admins:
- **Admin Panel:** `http://localhost/admin/dashboard`
- **Users List:** `http://localhost/admin/users`
- **Create User:** `http://localhost/admin/users/create`
- **Roles & Permissions:** `http://localhost/admin/roles`

---

## 🔧 Troubleshooting

### "Create User not working in admin panel"
**Solution:** Clear cache and routes
```bash
php artisan cache:clear
php artisan route:cache
php artisan config:cache
```

### "Role already exists" error
**Solution:** Run this to check existing roles
```bash
php artisan app:verify-roles
```

### "Client not redirected to dashboard"
**Check:**
1. User type should be `client`
2. User should have role (service_client or project_client)
3. Route `/client/dashboard` should work

---

## ✅ Current User Types & Roles

### User Types:
- **admin** - Administrator (internal staff)
- **client** - Client (external, has client_type)
- **employee** - Employee (internal staff)

### Current Roles:
1. **super_admin** - Full system access + role management
2. **admin** - Full system access (no role management)
3. **data_entry** - Add data only
4. **client_service** - ~~Deprecated~~ (use service_client)
5. **client_project** - ~~Deprecated~~ (use project_client)
6. **employee** - Basic employee access
7. **service_client** ← NEW - Service clients
8. **project_client** ← NEW - Project clients

---

## 📋 Testing Checklist

```
After setup, test these:

☐ Run cache clear commands
☐ Run app:create-client-roles
☐ Create super_admin via admin panel
☐ Login as super_admin
☐ Go to /admin/users
☐ Try creating admin user
☐ Go to /register (as guest)
☐ Register as service client
☐ Register as project client
☐ Verify clients see correct dashboards
☐ Verify auto-role assignment worked
☐ Verify service_client and project_client roles exist
```

---

## 🎉 You're All Set!

Your system now has:
✅ 8 roles (2 admin + 6 client/employee roles)  
✅ 3 ways to create users  
✅ Automatic role assignment for clients  
✅ Complete user management panel  
✅ Client self-registration  

**Next Steps:**
1. Run the cache clear commands
2. Run `php artisan app:create-client-roles`
3. Create your first super_admin user
4. Test client registration
5. Verify role assignments

---

**Questions?** Check the other documentation files for more details!
