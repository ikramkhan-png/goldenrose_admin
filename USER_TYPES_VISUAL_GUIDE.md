# 🎯 User Types Complete Guide - Visual

## 📊 The 5 User Types at a Glance

```
USER TYPES IN YOUR SYSTEM
═════════════════════════════════════════════════════════════════

1️⃣ SUPER ADMIN 👑
   type: 'admin'  |  client_type: null  |  role: 'super_admin'
   ├─ Full system access (13 permissions)
   ├─ Can manage everything
   ├─ Can manage roles (ONLY THIS ROLE CAN)
   ├─ Dashboard: /admin/dashboard
   ├─ Created: Via Tinker or Admin Panel
   └─ Access: All menus visible

2️⃣ SUB ADMIN ⚙️
   type: 'admin'  |  client_type: null  |  role: 'admin'
   ├─ Almost full access (12 permissions)
   ├─ Cannot manage roles (RESTRICTION)
   ├─ Can manage clients, services, projects
   ├─ Dashboard: /admin/dashboard
   ├─ Created: Via Tinker or Admin Panel
   └─ Access: All menus except "Roles & Permissions"

3️⃣ DATA ENTRY 📝
   type: 'admin'  |  client_type: null  |  role: 'data_entry'
   ├─ Limited access (6 permissions)
   ├─ Can add data only
   ├─ Cannot modify or delete existing data
   ├─ Cannot manage users or roles
   ├─ Dashboard: /admin/dashboard
   ├─ Created: Via Tinker or Admin Panel
   └─ Access: Limited menus (View + Add only)

4️⃣ SERVICE CLIENT 🛎️
   type: 'client'  |  client_type: 'service'  |  role: 'client_service'
   ├─ Client dashboard access (2 permissions)
   ├─ Cannot access admin panel
   ├─ Sees only their services & billing
   ├─ Dashboard: /client/dashboard (service view)
   ├─ Created: Via client registration form
   └─ Access: Service dashboard + support messaging

5️⃣ PROJECT CLIENT 📊
   type: 'client'  |  client_type: 'project'  |  role: 'client_project'
   ├─ Client dashboard access (2 permissions)
   ├─ Cannot access admin panel
   ├─ Sees only their projects & documents
   ├─ Dashboard: /client/dashboard (project view)
   ├─ Created: Via client registration form
   └─ Access: Project dashboard + support messaging
```

---

## 🔄 User Creation Flows

### FLOW 1: Creating Admin Users

```
┌─────────────────────────────────────────────────────────────┐
│ CREATING ADMIN/SUB-ADMIN/DATA-ENTRY USERS                  │
└─────────────────────────────────────────────────────────────┘

                        YOU (Super Admin)
                             ↓
                      Two Options:
                    ╱              ╲
                   ╱                ╲
         Quick (Tinker)    Professional (Admin Panel)
              ↓                      ↓
         php artisan              Visit: /admin/users
         tinker                         ↓
              ↓                    Click: [+ Add New User]
         Create User                    ↓
         .assignRole()             Fill Form:
              ↓                    - Name, Email, Phone
         Verify                    - Password
                                   - Select Role
                                        ↓
                                   Click: [Create User]
                                        ↓
                                   User Created
                                   Role Assigned
                                   Welcome Email (later)

```

### FLOW 2: Creating Client Users

```
┌─────────────────────────────────────────────────────────────┐
│ CREATING SERVICE/PROJECT CLIENT USERS                       │
└─────────────────────────────────────────────────────────────┘

                    CLIENT (New Customer)
                             ↓
                    Visits: /register
                             ↓
                    See Registration Form:
                    ├─ Name, Email, Phone, Password
                    └─ Q: What are you purchasing?
                       ├─ 🛎️ Services
                       └─ 📊 Projects
                             ↓
                    SELECT CLIENT TYPE
                             ↓
          ┌──────────────┬────────────────┐
          ↓              ↓                 ↓
    Service Client   OR   Project Client
    client_type:         client_type:
    'service'            'project'
          ↓              ↓
    Fill Form            Fill Form
          ↓              ↓
    Submit:              Submit:
    Auto Create          Auto Create
    Auto Assign Role     Auto Assign Role
    'client_service'     'client_project'
          ↓              ↓
    Auto Login           Auto Login
          ↓              ↓
    Redirect to:         Redirect to:
    /client/dashboard    /client/dashboard
          ↓              ↓
    See SERVICE         See PROJECT
    Dashboard            Dashboard
```

---

## 🗂️ Database Values Reference

### User Types Table

```sql
SELECT id, name, email, type, client_type, created_at FROM users;

id  name              email                type      client_type  created_at
──  ─────────────────  ──────────────────  ────────  ───────────  ──────────
1   Muhammad Ali      ali@goldenrose.com  admin     NULL         2026-03-01
2   Sara Manager      sara@goldenrose.com admin     NULL         2026-03-02
3   Ahmed Entry       ahmed@goldenrose.com admin     NULL         2026-03-03
4   ABC Industries    abc@company.com     client    service      2026-03-04
5   XYZ Construction  xyz@company.com     client    project      2026-03-05
```

### User Roles Mapping

```sql
SELECT u.name, r.name as role FROM users u
JOIN model_has_roles mhr ON u.id = mhr.model_id
JOIN roles r ON mhr.role_id = r.id;

name                 role
─────────────────   ───────────
Muhammad Ali        super_admin
Sara Manager         admin
Ahmed Entry         data_entry
ABC Industries      client_service
XYZ Construction    client_project
```

---

## 📍 Dashboard Routing

```
USER LOGS IN
    ↓
Auth Check
    ↓
    ├─ YES → Check type
    │   ├─ type='admin' → /admin/dashboard
    │   │   ├─ role='super_admin' → Full menu ✅
    │   │   ├─ role='admin' → No roles menu ❌
    │   │   └─ role='data_entry' → Limited menu ❌
    │   │
    │   └─ type='client' → ClientMiddleware
    │       ├─ client_type='service' → service-dashboard.blade.php
    │       └─ client_type='project' → project-dashboard.blade.php
    │
    └─ NO → /login
```

---

## 🔒 Permission Matrix

```
PERMISSION                  Super  Admin  Data   Serv   Proj   Emp
                           Admin  (sub)  Entry  Client Client loy
────────────────────────────────────────────────────────────────────
view_admin_dashboard         ✅     ✅     ✅     ❌     ❌     ✅
manage_clients               ✅     ✅     ✅     ❌     ❌     ❌
manage_services              ✅     ✅     ✅     ❌     ❌     ❌
manage_projects              ✅     ✅     ✅     ❌     ❌     ❌
manage_billings              ✅     ✅     ❌     ❌     ❌     ❌
manage_users                 ✅     ✅     ❌     ❌     ❌     ❌
manage_employees             ✅     ✅     ❌     ❌     ❌     ❌
manage_roles                 ✅     ❌     ❌     ❌     ❌     ❌  ⚠️ IMPORTANT
view_reports                 ✅     ✅     ✅     ❌     ❌     ❌
delete_data                  ✅     ✅     ❌     ❌     ❌     ❌
export_data                  ✅     ✅     ✅     ❌     ❌     ❌
view_client_dashboard        ❌     ❌     ❌     ✅     ✅     ❌
send_messages                ✅     ✅     ✅     ✅     ✅     ❌
```

**Key Points:**
- 👑 Super Admin: 13/13 ✅ (can do EVERYTHING)
- ⚙️ Admin: 12/13 ✅ (everything EXCEPT manage_roles)
- 📝 Data Entry: 6/13 ✅ (view + add only)
- 🛎️ Service Client: 2/13 ✅ (dashboard + messaging)
- 📊 Project Client: 2/13 ✅ (dashboard + messaging)
- 👤 Employee: 1/13 ✅ (dashboard only)

---

## 🎬 Complete User Journey

### An Admin User's Journey

```
ADMIN CREATED (via Tinker or Panel)
        ↓
    LOGIN (/login)
        ↓
    USERNAME: admin@golden.com
    PASSWORD: secret123
        ↓
    ✅ AUTH CHECK PASSES
        ↓
    Middleware checks: type = 'admin' ✅
        ↓
    Redirect to: /admin/dashboard
        ↓
    Dashboard loads
        ↓
    Sidebar shows based on role:
    ├─ role='super_admin' → ALL menus ✅
    ├─ role='admin' → Most menus (no roles) ✅
    └─ role='data_entry' → Limited menus ✅
        ↓
    Click around and work
        ↓
    LOGOUT (button in top right)
```

### A Service Client's Journey

```
CLIENT REGISTERS (/register)
        ↓
    NAME: ABC Company
    EMAIL: abc@company.com
    PASSWORD: secret456
    SELECT: 🛎️ Services
        ↓
    System creates user with:
    type: 'client'
    client_type: 'service'
        ↓
    System assigns role: 'client_service'
        ↓
    ✅ AUTO LOGIN
        ↓
    Redirect: /client/dashboard
        ↓
    ClientMiddleware checks:
    ├─ User authenticated? ✅
    ├─ User type = 'client'? ✅
    └─ client_type = 'service'? ✅
        ↓
    Dashboard loads: service-dashboard.blade.php
        ↓
    Shows:
    ├─ Services assigned to them
    ├─ Billing history
    ├─ Monthly breakdown
    └─ Support section
        ↓
    Can switch months, see different data
        ↓
    NO ACCESS TO /admin/dashboard
        ↓
    LOGOUT (button in client dashboard)
```

### A Project Client's Journey

```
CLIENT REGISTERS (/register)
        ↓
    NAME: XYZ Construction
    EMAIL: xyz@company.com
    PASSWORD: secret789
    SELECT: 📊 Projects
        ↓
    System creates user with:
    type: 'client'
    client_type: 'project'
        ↓
    System assigns role: 'client_project'
        ↓
    ✅ AUTO LOGIN
        ↓
    Redirect: /client/dashboard
        ↓
    ClientMiddleware checks:
    ├─ User authenticated? ✅
    ├─ User type = 'client'? ✅
    └─ client_type = 'project'? ✅
        ↓
    Dashboard loads: project-dashboard.blade.php
        ↓
    Shows:
    ├─ Projects assigned to them
    ├─ Budget tracking
    ├─ Progress indicator
    ├─ Project documents
    └─ Support section
        ↓
    Can switch months, see different billing
        ↓
    NO ACCESS TO /admin/dashboard
        ↓
    LOGOUT (button in client dashboard)
```

---

## 📋 Creation Checklists

### Creating Admin User (Tinker Method)

```bash
php artisan tinker

✓ Create user with: name, email, password, type='admin', client_type=null
✓ Assign role: super_admin / admin / data_entry
✓ Logout
✓ Test login as that user
✓ Verify dashboards and permissions
```

### Creating Service Client (Registration Form)

```
✓ User fills registration form
✓ User selects: 🛎️ Services
✓ Form validates
✓ User created with: type='client', client_type='service'
✓ Role assigned: 'client_service'
✓ User auto-logged in
✓ Redirected to /client/dashboard
✓ Sees service view ✓
```

### Creating Project Client (Registration Form)

```
✓ User fills registration form
✓ User selects: 📊 Projects
✓ Form validates
✓ User created with: type='client', client_type='project'
✓ Role assigned: 'client_project'
✓ User auto-logged in
✓ Redirected to /client/dashboard
✓ Sees project view ✓
```

---

## 🧪 Test Cases

### Test Case 1: Super Admin Can Manage Roles
```
1. Login as super_admin
2. Navigate to: Admin → Roles & Permissions
3. Should see menu and access page ✅
```

### Test Case 2: Admin Cannot Manage Roles
```
1. Login as admin (sub-admin)
2. Navigate to: Admin → Roles & Permissions
3. Should NOT see menu ❌
4. If typing URL directly: 403 Forbidden ❌
```

### Test Case 3: Data Entry Cannot Delete
```
1. Login as data_entry
2. Create new project
3. Try to delete existing project
4. Should not have delete button ❌
5. If typing URL directly: 403 Forbidden ❌
```

### Test Case 4: Service Client Sees Service Dashboard
```
1. Register as service client
2. Should redirect to /client/dashboard
3. Should see service view (services + billing)
4. Should NOT see projects
5. URL /admin should redirect to dashboard
```

### Test Case 5: Project Client Sees Project Dashboard
```
1. Register as project client
2. Should redirect to /client/dashboard
3. Should see project view (projects + budget)
4. Should NOT see services
5. Url /admin should redirect to dashboard
```

---

## 🚨 Common Confusion Points

❓ **Q: What's the difference between type and role?**
```
type: 'admin' / 'client' / 'employee'
└─ Determines if user is admin or client (basic categorization)

role: 'super_admin' / 'admin' / 'data_entry' / 'client_service' etc
└─ Determines what they can DO (permission level)

type determines which dashboard
role determines what menus/features they see
```

❓ **Q: Why set client_type to null for admins?**
```
client_type only applies to 'client' type users
admins should have NULL
keeps data clean and logic simple
```

❓ **Q: Can someone have multiple roles?**
```
Yes! You can do:
$user->syncRoles(['super_admin', 'client_service']);

But DON'T do this - keep one role per user for clarity
```

❓ **Q: Do I need to create employee dashboard?**
```
No, not now. Employee role is just placeholder.
If needed later, create: /employee/dashboard similar to client
```

---

## 📱 Your Dashboard Menus

### As Super Admin 👑
```
🏠 Dashboard
💼 Clients
   └─ All Clients
   └─ Service Clients
   └─ Project Clients
📊 Projects
🛎️ Services
👥 Employees
✓ Attendance
🏢 Departments
🔧 Machinery
👷 Manpower
🔐 Roles & Permissions
📈 Financial Reports
📋 Client Reports
⚙️ Settings
👤 My Profile
🚪 Logout
```

### As Admin (Sub-Admin) ⚙️
```
🏠 Dashboard
💼 Clients
   └─ All Clients
   └─ Service Clients
   └─ Project Clients
📊 Projects
🛎️ Services
👥 Employees
✓ Attendance
🏢 Departments
🔧 Machinery
👷 Manpower
📈 Financial Reports (if permission)
📋 Client Reports (if permission)
👤 My Profile
🚪 Logout

❌ No: Roles & Permissions (access denied)
❌ No: Settings (access denied)
```

### As Data Entry 📝
```
🏠 Dashboard
💼 Clients (Add only)
📊 Projects (Add only)
🛎️ Services (Add only)
👤 My Profile
🚪 Logout

❌ Can't edit or delete anything
❌ Can't manage users, employees, roles
❌ Limited to viewing existing data + adding new
```

### As Service Client 🛎️
```
🛎️ Service Dashboard
   ├─ Services List
   ├─ Billing By Month
   ├─ Payment Details
   └─ Support Messaging
```

### As Project Client 📊
```
📊 Project Dashboard
   ├─ Projects List
   ├─ Budget Tracking
   ├─ Project Documents
   ├─ Billing By Month
   └─ Support Messaging
```

---

**Everything is configured! You just need to update your registration form.**

✨ Happy Coding!
