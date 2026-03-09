# ⚡ Quick Fix - Route [client.query.store] not defined

## 🎯 The Error You're Seeing

```
Symfony\Component\Routing\Exception\RouteNotFoundException
Route [client.query.store] not defined.
```

This happens when you try to login as a client and the dashboard tries to load but can't find the route for submitting queries.

---

## ✅ **SOLUTION: Clear Route Cache** (Takes 30 seconds)

### Option 1: Use the Fix Script (Easiest)

```bash
cd /path/to/goldenrose_admin
bash fix-routes.sh
```

### Option 2: Manual Commands

```bash
cd /path/to/goldenrose_admin

php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan optimize:clear
```

### Option 3: If PHP command not found

```bash
# Try with specific PHP version
php8.3 artisan route:clear
# or
php8.2 artisan route:clear
# or
php8.1 artisan route:clear
```

---

## 🧪 Verify the Fix

After running the commands, check if the route exists:

```bash
php artisan route:list | grep "client.query"
```

**You should see:**
```
POST      client/query      client.query.store
```

---

## 🚀 Now Try Logging In Again

1. Go to: `http://your-domain/login`
2. Login with client credentials:
   - **Service Client:** `service@client.com` / `password`
   - **Project Client:** `project@client.com` / `password`
3. You should now see the client dashboard ✅

---

## 🔧 If It Still Doesn't Work

### Step 1: Make sure test clients exist

```bash
php artisan db:seed --class=TestClientSeeder
```

### Step 2: Check if user is configured correctly

```bash
php artisan client:check service@client.com
```

This will show you what's wrong and how to fix it.

### Step 3: Verify migrations ran

```bash
php artisan migrate
```

### Step 4: Check the full guide

See `TROUBLESHOOTING.md` for detailed solutions to other issues.

---

## 📋 Why This Happens

Laravel caches routes for performance. Sometimes after:
- Pulling new code from git
- Changing route files
- Server restart
- Deployment

The route cache can become outdated and Laravel can't find new routes.

**Solution:** Always clear the route cache after updating code!

---

## ✨ Quick Commands Cheat Sheet

```bash
# Fix routing issues
bash fix-routes.sh

# Create a client
php artisan client:create "Name" "email@test.com" "password" service

# Check client setup
php artisan client:check email@test.com

# View all routes
php artisan route:list | grep client

# Seed test clients
php artisan db:seed --class=TestClientSeeder
```

---

## 🎉 Done!

After running `bash fix-routes.sh`, the error should be gone and you can login as a client!

If you still have issues, check:
1. **TROUBLESHOOTING.md** - Complete troubleshooting guide
2. **CLIENT_LOGIN_GUIDE.md** - Client setup guide
3. **SETUP_INSTRUCTIONS.md** - Full setup instructions

**Need more help?** Run `php artisan client:check your-email@example.com` for diagnostics!
