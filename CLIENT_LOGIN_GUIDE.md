# 🔐 Client Login Guide - Golden Rose Admin

## Quick Start - Test Client Login

### 📋 Pre-configured Test Accounts

After running the seeder, you'll have these test accounts:

#### Service Client
- **Email:** `service@client.com`
- **Password:** `password`
- **Type:** Service Client
- **Dashboard:** `/client/dashboard` (Service View)

#### Project Client
- **Email:** `project@client.com`
- **Password:** `password`
- **Type:** Project Client
- **Dashboard:** `/client/dashboard` (Project View)

---

## 🚀 Setup Instructions

### Step 1: Run Database Seeder

If you haven't already seeded the database, run:

```bash
php artisan db:seed
```

Or to run only the client seeder:

```bash
php artisan db:seed --class=TestClientSeeder
```

### Step 2: Test Client Login

1. Navigate to: `http://your-domain/login`
2. Use one of the test accounts above
3. Click "Sign In to Dashboard"
4. You should be redirected to `/client/dashboard`

---

## ✅ Troubleshooting

### Issue: 404 Error on Client Dashboard

**Check 1: Verify User Has Correct Type**
```php
// In tinker or database
$user = User::where('email', 'service@client.com')->first();
echo $user->type; // Should be "client"
echo $user->client_type; // Should be "service" or "project"
```

**Check 2: Verify User Has Correct Role**
```php
// In tinker
$user = User::where('email', 'service@client.com')->first();
$user->roles; // Should show "client_service" or "client_project"
```

**Check 3: Verify Routes Are Registered**
```bash
php artisan route:list | grep client.dashboard
```

**Check 4: Clear Cache**
```bash
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### Issue: Access Denied / 403 Error

This means the middleware is blocking access. Check:

1. **User type is 'client':**
   - Must be set in the users table
   
2. **User has client_type:**
   - Must be either 'service' or 'project'
   
3. **User has correct role:**
   - Service clients need `client_service` role
   - Project clients need `client_project` role

### Issue: Redirect Loop

Check your middleware configuration in `bootstrap/app.php`:

```php
$middleware->alias([
    'auth' => \App\Http\Middleware\Authenticate::class,
    'client' => \App\Http\Middleware\ClientMiddleware::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
]);
```

---

## 📝 Creating New Client Users

### Via Admin Dashboard

1. Login as admin
2. Go to Users Management
3. Click "Create New User"
4. Fill in:
   - Name: Client Name
   - Email: client@example.com
   - Password: secure_password
   - Type: **client**
   - Client Type: **service** or **project**
5. Save

### Via Artisan Command

Create a custom command to quickly add clients:

```bash
php artisan make:command CreateClientUser
```

Example command usage:
```bash
php artisan client:create "John Doe" john@example.com password service
```

---

## 🔍 Testing Checklist

- [ ] Service client can login
- [ ] Project client can login
- [ ] Client dashboard loads without 404
- [ ] Client sees their services (if any assigned)
- [ ] Client sees their projects (if any assigned)
- [ ] Client can submit queries via floating button
- [ ] Client can view important notes from admin
- [ ] Client can logout successfully
- [ ] After logout, redirect to login page works

---

## 🎨 Client Dashboard Features

### What Clients Can See

1. **Statistics Cards**
   - Assigned Services Count
   - Active Projects Count
   - Total Contract Value
   - Balance Due

2. **Services Section**
   - List of assigned services
   - Rate types (Hourly/Daily/Monthly)
   - Duration and amounts
   - Total service amount

3. **Projects Section**
   - List of assigned projects
   - Project types
   - Budget and payment info
   - Total contract value

4. **Important Notes**
   - Admin messages and notifications
   - Unread badge for new notes
   - Attachments if any

5. **Project Updates**
   - Document uploads from admin
   - Project status updates
   - Download links

6. **Support Section**
   - Contact information
   - Phone, email, office address
   - Floating query button

### What Clients Can Do

- ✅ View assigned services and projects
- ✅ Check billing and payment status
- ✅ Submit support queries with attachments
- ✅ View project documents and updates
- ✅ Read admin notes and mark as read
- ❌ Cannot access admin dashboard
- ❌ Cannot create other users
- ❌ Cannot modify billing data

---

## 🔐 Security Notes

1. **Registration Disabled**
   - Public registration route is disabled
   - Only admins can create client accounts
   - Prevents unauthorized account creation

2. **Middleware Protection**
   - Client routes protected by `ClientMiddleware`
   - Validates user type and client_type
   - Returns 403 for unauthorized access

3. **Role-Based Access**
   - Service clients: `client_service` role
   - Project clients: `client_project` role
   - Both have `view_client_dashboard` permission

---

## 📞 Need Help?

If you're still experiencing issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check web server logs
3. Enable debug mode in `.env`:
   ```
   APP_DEBUG=true
   ```
4. Test the debug route:
   ```
   http://your-domain/debug-auth
   ```

---

## 🎯 Quick Commands Reference

```bash
# Seed test clients
php artisan db:seed --class=TestClientSeeder

# Clear all caches
php artisan optimize:clear

# Check routes
php artisan route:list | grep client

# Check permissions
php artisan permission:cache-reset

# Create migration
php artisan migrate:fresh --seed
```

---

**Happy Testing! 🎉**

If you need to modify the client dashboard appearance or functionality, edit:
- Controller: `app/Http/Controllers/Admin/ClientDashboardController.php`
- View: `resources/views/client/dashboard/index.blade.php`
- Routes: `routes/web.php` (search for 'client.')
