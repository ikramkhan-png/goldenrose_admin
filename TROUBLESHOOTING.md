# 🔧 Troubleshooting Guide - Golden Rose Admin

## Common Issues & Solutions

### ❌ Error: Route [client.query.store] not defined

This error occurs when Laravel can't find the route. Here's how to fix it:

#### **Solution 1: Clear All Caches (RECOMMENDED)**

Run this command in your project root:

```bash
bash fix-routes.sh
```

Or manually run these commands:

```bash
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear
```

#### **Solution 2: Verify Routes Are Registered**

Check if the route exists:

```bash
php artisan route:list | grep client
```

You should see:
```
POST      client/query                  client.query.store
GET|HEAD  client/dashboard              client.dashboard
POST      client/note/{id}/read         client.note.read
```

If routes are missing, the web.php file might not be loading correctly.

#### **Solution 3: Check Route Cache**

Sometimes routes get cached in production. Clear it:

```bash
php artisan route:cache
```

Or if that doesn't work:

```bash
rm bootstrap/cache/routes-*.php
php artisan route:clear
```

---

### ❌ Error: 404 Not Found on /client/dashboard

#### **Solution 1: Check User Configuration**

Use the diagnostic command:

```bash
php artisan client:check your-email@example.com
```

This will show:
- User type (must be "client")
- Client type (must be "service" or "project")
- Assigned roles
- Permissions
- What's wrong and how to fix it

#### **Solution 2: Verify User Settings Manually**

```bash
php artisan tinker
```

Then run:
```php
$user = User::where('email', 'your-email@example.com')->first();

// Check type
echo $user->type; // Should be "client"

// Check client type
echo $user->client_type; // Should be "service" or "project"

// Check roles
$user->roles; // Should show client_service or client_project

// If wrong, fix it:
$user->type = 'client';
$user->client_type = 'service';
$user->save();
$user->assignRole('client_service');
```

#### **Solution 3: Re-create the User**

Delete and recreate the client:

```bash
# Create new client
php artisan client:create "John Doe" "john@example.com" "password" service
```

---

### ❌ Error: 403 Forbidden / Unauthorized Access

This means the middleware is blocking access.

#### **Solution: Check Middleware**

1. **Verify user has correct type:**
   ```bash
   php artisan tinker
   $user = User::find(YOUR_USER_ID);
   echo $user->type; // Must be "client"
   ```

2. **Verify user has client_type:**
   ```bash
   echo $user->client_type; // Must be "service" or "project"
   ```

3. **Check middleware file:**
   File: `app/Http/Middleware/ClientMiddleware.php`
   
   Should validate:
   - User is authenticated
   - User type is 'client'
   - User has client_type ('service' or 'project')

---

### ❌ Error: Tables Don't Exist (client_notes, client_queries)

#### **Solution: Run Migrations**

```bash
php artisan migrate
```

If migrations already ran, check if tables exist:

```bash
php artisan tinker
```

```php
// Check if tables exist
DB::select("SHOW TABLES LIKE 'client_notes'");
DB::select("SHOW TABLES LIKE 'client_queries'");
```

If tables don't exist:

```bash
# Fresh migration (WARNING: This will delete all data!)
php artisan migrate:fresh

# Then seed the database
php artisan db:seed
```

---

### ❌ Error: Class 'Spatie\Permission\Models\Role' not found

#### **Solution: Install Spatie Package**

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
```

---

### ❌ Login Works but Redirects to Wrong Dashboard

#### **Solution: Check Login Logic**

File: `resources/views/livewire/pages/auth/login.blade.php`

The login method should check user type:

```php
$user = Auth::user();

if ($user->type === 'client') {
    $this->redirect(route('client.dashboard'), navigate: false);
} else {
    $this->redirect(route('admin.dashboard'), navigate: false);
}
```

If this doesn't work, check middleware aliases in `bootstrap/app.php`:

```php
$middleware->alias([
    'auth' => \App\Http\Middleware\Authenticate::class,
    'client' => \App\Http\Middleware\ClientMiddleware::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
]);
```

---

### ❌ Session/Auth Issues - User Keeps Getting Logged Out

#### **Solution 1: Check Session Configuration**

File: `.env`

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

#### **Solution 2: Clear Sessions**

```bash
php artisan session:clear
rm -rf storage/framework/sessions/*
```

#### **Solution 3: Check App Key**

```bash
php artisan key:generate
```

---

### ❌ View Not Found: client.dashboard.index

#### **Solution: Verify View Exists**

Check if this file exists:
```
resources/views/client/dashboard/index.blade.php
```

If missing, the file might have been deleted. Check git:

```bash
git status
git checkout resources/views/client/dashboard/index.blade.php
```

---

### ❌ SQLSTATE Error: Foreign Key Constraint Fails

This happens when trying to create relationships with missing data.

#### **Solution: Seed Roles First**

```bash
php artisan db:seed --class=RolePermissionSeeder
```

Then create users:

```bash
php artisan db:seed --class=TestClientSeeder
```

---

## 🔍 Debugging Tools

### 1. Check Authentication Status

Visit: `http://your-domain/debug-auth`

This shows:
- Is user authenticated?
- User ID and email
- User type
- Session status
- Available routes

### 2. View All Routes

```bash
php artisan route:list
```

Filter for specific routes:

```bash
php artisan route:list | grep client
php artisan route:list | grep admin
php artisan route:list | grep login
```

### 3. Check Logs

```bash
tail -f storage/logs/laravel.log
```

### 4. Enable Debug Mode

File: `.env`

```env
APP_DEBUG=true
APP_ENV=local
```

**⚠️ Never enable debug mode in production!**

---

## 📋 Pre-Flight Checklist

Before testing client login:

- [ ] Migrations ran: `php artisan migrate`
- [ ] Roles seeded: `php artisan db:seed --class=RolePermissionSeeder`
- [ ] Test clients created: `php artisan db:seed --class=TestClientSeeder`
- [ ] Caches cleared: `bash fix-routes.sh`
- [ ] Routes exist: `php artisan route:list | grep client`
- [ ] Views exist: Check `resources/views/client/dashboard/`
- [ ] Controllers exist: Check `app/Http/Controllers/Admin/ClientDashboardController.php`
- [ ] Middleware exists: Check `app/Http/Middleware/ClientMiddleware.php`

---

## 🆘 Still Having Issues?

### Step 1: Run Diagnostics

```bash
# Check if user is configured correctly
php artisan client:check service@client.com

# Check routes
php artisan route:list | grep client

# Check database
php artisan tinker
DB::table('users')->where('type', 'client')->get();
```

### Step 2: Check File Permissions

```bash
# Make sure Laravel can write to these directories
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### Step 3: Fresh Install

If all else fails, start fresh:

```bash
# Backup database first!
php artisan migrate:fresh
php artisan db:seed
bash fix-routes.sh
```

### Step 4: Check Logs

```bash
# Laravel logs
tail -100 storage/logs/laravel.log

# Web server logs
tail -100 /var/log/nginx/error.log  # Nginx
tail -100 /var/log/apache2/error.log  # Apache
```

---

## 📞 Getting Help

If you've tried everything:

1. **Check logs:** `storage/logs/laravel.log`
2. **Run diagnostics:** `php artisan client:check user@email.com`
3. **Clear caches:** `bash fix-routes.sh`
4. **Check routes:** `php artisan route:list | grep client`
5. **Verify database:** Tables exist and have data

Include this information when asking for help:
- Laravel version: `php artisan --version`
- PHP version: `php -v`
- Error message (full stack trace)
- What you've already tried
- Output from: `php artisan client:check user@email.com`

---

## ✅ Quick Fixes Summary

| Error | Quick Fix |
|-------|-----------|
| Route not defined | `bash fix-routes.sh` |
| 404 on dashboard | `php artisan client:check email` |
| 403 Forbidden | Check user type & client_type |
| Tables missing | `php artisan migrate` |
| User can't login | `php artisan client:create` |
| Session issues | `php artisan session:clear` |
| View not found | Check `resources/views/client/dashboard/` |

---

**Most Common Fix:** Run `bash fix-routes.sh` - solves 80% of issues! 🎯
