# 🎯 User Types & Creation Guide

## 📋 The 5 User Types in Your System

### 1. **👑 Super Admin User**
```php
type: 'admin'
client_type: null
```
- Full system access
- Can manage everything including roles
- Used by: Owner/Senior management

**When to create:** System setup, trust senior staff only

---

### 2. **⚙️ Admin/Sub Admin User**
```php
type: 'admin'
client_type: null
```
- Almost full access
- Cannot manage roles (critical restriction)
- Can manage clients, services, projects
- Used by: Management team

**When to create:** For trusted team members who need most features

---

### 3. **📝 Data Entry User**
```php
type: 'admin'
client_type: null
```
- Can add data only
- Cannot modify or delete
- Used by: Data entry staff

**When to create:** For staff that only inputs new data

---

### 4. **🛎️ Service Client User**
```php
type: 'client'
client_type: 'service'
```
- Views service dashboard
- Sees assigned services and billing
- Cannot access admin panel
- Used by: Clients buying services

**When to create:** Through client registration form

---

### 5. **📊 Project Client User**
```php
type: 'client'
client_type: 'project'
```
- Views project dashboard
- Sees assigned projects and budget
- Cannot access admin panel
- Used by: Clients with projects

**When to create:** Through client registration form

---

## 🔧 How to Create Each User Type

### **Method 1: Via Artisan Tinker** (Quick)

```bash
php artisan tinker
```

#### Create Super Admin
```php
$user = User::create([
    'name' => 'Admin Name',
    'email' => 'admin@goldenrose.com',
    'password' => bcrypt('password123'),
    'type' => 'admin',
    'client_type' => null,
    'phone' => '1234567890'
]);

$user->assignRole('super_admin');
exit
```

#### Create Sub Admin
```php
$user = User::create([
    'name' => 'Manager Name',
    'email' => 'manager@goldenrose.com',
    'password' => bcrypt('password123'),
    'type' => 'admin',
    'client_type' => null,
    'phone' => '0987654321'
]);

$user->assignRole('admin');
exit
```

#### Create Data Entry User
```php
$user = User::create([
    'name' => 'Data Entry Staff',
    'email' => 'entry@goldenrose.com',
    'password' => bcrypt('password123'),
    'type' => 'admin',
    'client_type' => null,
    'phone' => '5555555555'
]);

$user->assignRole('data_entry');
exit
```

#### Create Service Client
```php
$client = User::create([
    'name' => 'ABC Services Client',
    'email' => 'abc@client.com',
    'password' => bcrypt('password123'),
    'type' => 'client',
    'client_type' => 'service',
    'phone' => '1111111111'
]);

$client->assignRole('client_service');
exit
```

#### Create Project Client
```php
$client = User::create([
    'name' => 'XYZ Project Client',
    'email' => 'xyz@client.com',
    'password' => bcrypt('password123'),
    'type' => 'client',
    'client_type' => 'project',
    'phone' => '2222222222'
]);

$client->assignRole('client_project');
exit
```

---

### **Method 2: Via User Admin Panel** (Recommended for ongoing use)

Create an **Admin Users Management** page in your admin panel:

```blade
<!-- resources/views/admin/users/create.blade.php -->
<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <div class="form-group">
        <label>User Type</label>
        <select name="type" class="form-control" required>
            <option value="">Select Type</option>
            <option value="admin">Admin User</option>
            <option value="client">Client User</option>
        </select>
    </div>

    <div class="form-group" id="client_type_group" style="display:none;">
        <label>Client Type</label>
        <select name="client_type" class="form-control">
            <option value="">Select</option>
            <option value="service">Service Client</option>
            <option value="project">Project Client</option>
        </select>
    </div>

    <div class="form-group">
        <label>Assign Role</label>
        <select name="role" class="form-control" required>
            <option value="">Select Role</option>
            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create User</button>
</form>

<script>
document.querySelector('[name="type"]').addEventListener('change', function() {
    const group = document.getElementById('client_type_group');
    group.style.display = this.value === 'client' ? 'block' : 'none';
});
</script>
```

---

### **Method 3: For Clients** (Your Registration Form)

Since you have a client registration form, extend it to include role assignment:

```php
// In your client registration controller
public function register(Request $request)
{
    $client = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'type' => 'client',
        'client_type' => $request->client_type, // 'service' or 'project'
        'phone' => $request->phone
    ]);

    // Auto-assign the correct role based on client_type
    if ($request->client_type === 'service') {
        $client->assignRole('client_service');
    } else {
        $client->assignRole('client_project');
    }

    return redirect()->route('login')
        ->with('success', 'Registration successful! Please login.');
}
```

---

## 📊 Quick Reference Table

| User Type | type | client_type | role | Can Access |
|-----------|------|-------------|------|-----------|
| Super Admin | admin | null | super_admin | Admin panel + manage roles |
| Sub Admin | admin | null | admin | Admin panel (except roles) |
| Data Entry | admin | null | data_entry | Admin panel (add only) |
| Service Client | client | 'service' | client_service | Service dashboard |
| Project Client | client | 'project' | client_project | Project dashboard |

---

## ✅ Testing Your Users

### Test Super Admin
```
1. Go to /admin/dashboard
2. Should see full dashboard with all options
3. Can create/edit/delete everything
4. Can manage roles
```

### Test Sub Admin
```
1. Go to /admin/dashboard
2. Should see most options
3. Cannot access "Roles & Permissions" menu
```

### Test Data Entry
```
1. Go to /admin/dashboard
2. Can only add new data
3. Cannot delete or edit existing data
4. Cannot see most management features
```

### Test Service Client
```
1. Login with service client account
2. Auto-redirected to /client/dashboard
3. Cannot access /admin/dashboard
4. See services and billing only
```

### Test Project Client
```
1. Login with project client account
2. Auto-redirected to /client/dashboard
3. Cannot access /admin/dashboard
4. See projects and budget only
```

---

## 🔄 Workflow for Creating Users

### For Admin Users:
```
1. Use Artisan Tinker (during setup)
   OR
2. Use Admin Users Manager (ongoing)
3. Assign appropriate role
4. Provide credentials to staff
5. They login and access /admin/dashboard
```

### For Client Users:
```
1. Client visits registration page
2. Fills form (name, email, phone, type)
3. System creates user with correct type
4. System assigns correct role automatically
5. User can login and see their dashboard
```

---

## 💡 Pro Tips

1. **Always set both type and client_type** correctly
2. **Assign role immediately** after user creation
3. **For admins**: Use the admin panel for easier management
4. **For clients**: Automate role assignment in registration
5. **Test each user type** before going live
6. **Keep super admin count low** - security best practice

---

## 🚨 Common Mistakes to Avoid

❌ **WRONG:**
```php
User::create([
    'name' => 'John',
    'email' => 'john@example.com',
    'type' => 'admin',
    // Missing client_type - should be null
    // Missing role assignment
]);
```

✅ **CORRECT:**
```php
$user = User::create([
    'name' => 'John',
    'email' => 'john@example.com',
    'password' => bcrypt('password'),
    'type' => 'admin',
    'client_type' => null, // Explicitly set to null
    'phone' => '1234567890'
]);

$user->assignRole('super_admin'); // Always assign role
```

---

## 📱 Your Client Registration Flow

Since you have a client registration form, here's the recommended flow:

```
Registration Page
    ↓
    [Select: Service or Project]
    ↓
Fill Details (name, email, password, phone)
    ↓
System Creates User with correct type & client_type
    ↓
System Assigns Correct Role Automatically
    ↓
User Redirected to Login
    ↓
User Logs In
    ↓
Auto-redirected to /client/dashboard
    ↓
Sees Their Dashboard (Service or Project)
```

This way, you don't need to manually manage client users!
