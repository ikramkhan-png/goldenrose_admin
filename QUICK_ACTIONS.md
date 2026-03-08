# 🚀 Quick Action Guide - Users Management

## 📍 Accessing Users Management

**Menu Path:** Admin Dashboard → System → Users Management  
**Direct URL:** `http://localhost/admin/users`  
**Required Role:** Super Admin

---

## 🎯 Common Tasks

### 1. Create New Super Admin User
```
Step 1: Click "Create New User" button (top right)
Step 2: Fill the form with:
        Name: Admin User Name
        Email: admin@company.com
        Phone: +1-555-0123
        User Type: admin (dropdown)
        Password: StrongPassword@123
        Confirm Password: StrongPassword@123
        Assigned Role: super_admin (dropdown)
Step 3: Click "Create User" green button
Step 4: Will redirect to users list automatically
```

### 2. Create Internal Employee User
```
Step 1: Click "Create New User" button
Step 2: Fill the form with:
        Name: Employee Name
        Email: employee@company.com
        Phone: +1-555-0234
        User Type: employee (dropdown)
        Password: EmployeePass@123
        Confirm Password: EmployeePass@123
        Assigned Role: employee (dropdown)
Step 3: Click "Create User" button
Step 4: Redirects to users list
```

### 3. Create Data Entry User
```
Step 1: Click "Create New User" button
Step 2: Fill the form with:
        Name: Data Entry User
        Email: dataentry@company.com
        Phone: +1-555-0345
        User Type: admin (dropdown)        ← Important: Set as admin type
        Password: DataPass@123
        Confirm Password: DataPass@123
        Assigned Role: data_entry (dropdown)
Step 3: Click "Create User" button
```

---

## 👥 Edit Existing User

```
Step 1: Go to Users Management page
Step 2: In table, find the user you want to edit
Step 3: Click "Edit" button (pencil icon)
Step 4: Update any field:
        - Name
        - Email
        - Phone
        - User Type
        - Password (optional - leave blank to keep current)
        - Role assignment
Step 5: Click "Update User" button
Step 6: Will show user details after update
```

---

## 👁️ View User Details

```
Step 1: Go to Users Management page
Step 2: Click on user name (links to show page)
        OR click "View" button (eye icon)
Step 3: See profile:
        - Personal info (Name, Email, Phone)
        - Account info (Type, Roles, Joined date)
        - Any assigned permissions
        - Edit or delete options
```

---

## 🚪 Delete User

```
WARNING: Cannot delete:
- Super Admin users
- Your own account
- Cascade deletion of associated data

Step 1: Go to Users Management
Step 2: Find user to delete
Step 3: Click "Delete" button (trash icon)
Step 4: Confirm deletion in modal
Step 5: User will be removed from system
```

---

## 🔑 Register New Client (Public)

**Access:** Requires no login!  
**URL:** `http://localhost/register`

```
Step 1: Go to /register
Step 2: Fill registration form with:
        Name: Client Name
        Email: client@email.com
        Phone: +1-555-9999
        Client Type: Choose one:
                     - 🛎️ Services (gets service_client role)
                     - 📊 Projects (gets project_client role)
        Password: ClientPass@123
        Confirm Password: ClientPass@123
Step 3: Click "Create Account" button
Step 4: Auto role assigned immediately
Step 5: Auto redirected to client dashboard
```

---

## 🔍 Search & Filter Users

```
Features on Users Management page:

1. Statistics Cards (Top):
   - Total Users count
   - Admin Users count
   - Client Users count
   - Additional staff count

2. Table Features:
   - Sort by clicking column headers
   - Scroll horizontally on mobile
   - Pagination at bottom (if many users)
   - Search box (if implemented)
   - Filter by type (if implemented)

3. Action Buttons:
   - View: See full details
   - Edit: Modify user info/role
   - Delete: Remove user (with confirmation)
```

---

## 📊 User Statistics

```
The Users Management page shows:

Total Users:     All users in system
Admin Users:     admin and super_admin types
Client Users:    client type (service and project)
Staff/Employees: employee type users

These update automatically as users are created/deleted
```

---

## 🔐 Permission Assignment for Super Admin

```
Super Admin has access to:

1. User Management:
   - Create/Read/Update/Delete users
   - Assign roles to users
   - View user permissions
   - Register clients
   - Create internal staff

2. Role Management:
   - Create new roles
   - Edit roles and permissions
   - Delete roles (if no users assigned)
   - Modify permission mappings

3. System Management:
   - Access all sections
   - View all data
   - Manage settings
   - Configure system
```

---

## ⚠️ Important Warnings

```
1. CANNOT EDIT:
   [✓] Cannot change super_admin user type to anything else
   [✓] Cannot delete super_admin users
   [✓] Cannot delete your own account
   [✓] Cannot change system role users' fundamental access

2. MUST HAVE:
   [✓] Every user must have unique email
   [✓] Every user must have a user type (admin/client/employee)
   [✓] Every client user must have client_type (service/project)
   [✓] Every user must have at least one role assigned

3. DATA SAFETY:
   [✓] User deletion is permanent
   [✓] Associated data may be preserved or cascade-deleted
   [✓] Changing roles removes old permissions
   [✓] Always verify before deleting
```

---

## 🎯 Next: Create Your First Admin User

**To fully set up the system:**

1. Go to: `http://localhost/admin/users/create`
2. Fill in your admin user details
3. Set Role to: `super_admin`
4. Click "Create User"
5. You now have full system access!

---

**For full documentation, see SETUP_COMPLETE.md**
