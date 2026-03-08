# 🔍 TROUBLESHOOTING GUIDE - Authentication Redirect Issue

## 🚨 Problem
When accessing `/login` or any route while NOT logged in, you're being redirected to `/admin/dashboard` which shows a 404 error.

---

## ✅ STEP-BY-STEP DEBUGGING (DO THIS NOW)

### **Step 1: Pull Latest Changes**
```bash
cd /path/to/goldenrose_admin
git pull origin main
```

### **Step 2: Clear EVERYTHING** 
```bash
# Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan clear-compiled

# Clear compiled class files
composer dump-autoload
```

### **Step 3: Force Logout (Clear Session)**

Open your browser and go to:
```
http://goldenrose_admin.test/force-logout
```

This will:
- ✅ Log you out
- ✅ Invalidate your session
- ✅ Clear any stuck authentication state
- ✅ Redirect you to login

### **Step 4: Check Authentication Status**

Open your browser and go to:
```
http://goldenrose_admin.test/debug-auth
```

**You should see JSON output like this:**
```json
{
  "authenticated": false,
  "user_id": null,
  "user_email": "Not logged in",
  "user_type": "N/A",
  "session_id": "some_session_id",
  "has_session": true,
  "intended_url": null,
  "login_route_exists": true,
  "admin_dashboard_route_exists": true
}
```

**✅ GOOD:** If `authenticated` is `false`
**❌ BAD:** If `authenticated` is `true` (even though you logged out)

### **Step 5: Test Simple Route**

Go to:
```
http://goldenrose_admin.test/test-login-page
```

**✅ GOOD:** You should see "TEST LOGIN PAGE - If you see this, routing works!"
**❌ BAD:** If you get redirected elsewhere

### **Step 6: Try Login Again**

Now try:
```
http://goldenrose_admin.test/login
```

**✅ EXPECTED:** Login form appears
**❌ IF STILL REDIRECTING:** Continue to Step 7

---

## 🔧 **Step 7: Nuclear Option - Clear Browser & Session**

### A. Clear Browser Completely

**Chrome/Edge:**
1. Press `Ctrl + Shift + Delete` (Windows) or `Cmd + Shift + Delete` (Mac)
2. Select "All time"
3. Check: Cookies, Cached images and files
4. Click "Clear data"

**Firefox:**
1. Press `Ctrl + Shift + Delete`
2. Select "Everything"
3. Check: Cookies, Cache
4. Click "Clear Now"

**OR** Just use **Incognito/Private browsing mode**!

### B. Clear Laravel Session Files

```bash
# Option 1: Flush all sessions
php artisan session:flush

# Option 2: Manually delete session files
rm -rf storage/framework/sessions/*

# Option 3: Delete specific session (if file driver)
ls -la storage/framework/sessions/
```

### C. Clear All Cookies Manually

1. Open your browser
2. Open Developer Tools (F12)
3. Go to "Application" tab (Chrome) or "Storage" tab (Firefox)
4. Click "Cookies"
5. Find `goldenrose_admin.test`
6. Delete ALL cookies for this domain

---

## 📊 **Step 8: Check Results**

After clearing everything, check `/debug-auth` again:

```
http://goldenrose_admin.test/debug-auth
```

| Field | Expected Value | If Different |
|-------|---------------|--------------|
| `authenticated` | `false` | Session not cleared properly |
| `user_id` | `null` | Still logged in somehow |
| `login_route_exists` | `true` | Routes not loaded |
| `admin_dashboard_route_exists` | `true` | Routes not loaded |

---

## 🔍 **Step 9: Check Web Server Configuration**

### For Laravel Valet (Mac):
```bash
valet links
valet restart
```

### For Laravel Herd:
```bash
herd restart
```

### For Nginx:

Check if there's a custom redirect in the Nginx config:

```bash
# Find your site configuration
cat /etc/nginx/sites-available/goldenrose_admin.test

# Look for any 'rewrite' or 'return' directives
# There should NOT be any custom redirects
```

**Correct Nginx config should look like:**
```nginx
server {
    listen 80;
    server_name goldenrose_admin.test;
    root /path/to/goldenrose_admin/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**If you find weird redirects, remove them and restart:**
```bash
sudo systemctl restart nginx
```

---

## 🧪 **Step 10: Test Middleware Directly**

Create a test to see if middleware is working:

```bash
# Open terminal in project root
php artisan tinker
```

Then run:
```php
Route::getRoutes()->getByName('login');
Route::getRoutes()->getByName('admin.dashboard');
exit
```

This should show both routes exist.

---

## 🐛 **Step 11: Check Error Logs**

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check web server logs
# For Nginx:
tail -f /var/log/nginx/error.log

# For Apache:
tail -f /var/log/apache2/error.log
```

While tailing logs, try to access `/login` and see what errors appear.

---

## 💡 **Step 12: Common Issues & Solutions**

### Issue 1: "Session driver not configured"
**Solution:**
```bash
# Check .env file
cat .env | grep SESSION_DRIVER

# Should be:
SESSION_DRIVER=file

# If missing, add it to .env
echo "SESSION_DRIVER=file" >> .env

# Then clear config
php artisan config:clear
```

### Issue 2: "Permission denied" on session storage
**Solution:**
```bash
sudo chmod -R 775 storage
sudo chown -R $USER:www-data storage
```

### Issue 3: Routes not found (404 on everything)
**Solution:**
```bash
# Check if public directory is web root
ls -la public/

# Rebuild route cache
php artisan route:cache

# List all routes to verify
php artisan route:list | grep login
```

### Issue 4: Livewire not working
**Solution:**
```bash
# Reinstall Livewire assets
php artisan livewire:publish --assets

# Clear view cache
php artisan view:clear
```

---

## 🎯 **Expected Flow (After Fix)**

```
┌─────────────────────────────────────────────┐
│ User types: /login (Not authenticated)     │
└────────────┬────────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────────┐
│ Laravel checks middleware: 'guest'          │
└────────────┬────────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────────┐
│ Is user authenticated?                      │
│   NO ──> Show login page ✅                │
│   YES ──> Redirect to dashboard             │
└─────────────────────────────────────────────┘
```

---

## 📞 **Still Not Working? Report These Details:**

If after ALL these steps it STILL doesn't work, provide me with:

1. **Output of `/debug-auth`**
   ```
   Visit: http://goldenrose_admin.test/debug-auth
   Copy and paste the JSON output
   ```

2. **Output of route list:**
   ```bash
   php artisan route:list | grep -E "login|dashboard"
   ```

3. **Session driver:**
   ```bash
   cat .env | grep SESSION_DRIVER
   ```

4. **Laravel version:**
   ```bash
   php artisan --version
   ```

5. **Error logs:**
   ```bash
   tail -20 storage/logs/laravel.log
   ```

6. **Web server:**
   - Are you using Valet, Herd, Nginx, Apache, or Docker?

7. **Browser console errors:**
   - Open Developer Tools (F12)
   - Check Console tab
   - Copy any red errors

---

## ⚠️ **IMPORTANT NOTES**

1. **Always use incognito mode when testing** to avoid cached cookies
2. **The `/debug-auth` route is your friend** - check it often!
3. **Clear caches after EVERY code change** 
4. **Restart web server after clearing caches**
5. **If using Valet/Herd, restart those services**

---

## ✅ **Success Indicators**

You'll know it's working when:

- ✅ `/debug-auth` shows `authenticated: false` when logged out
- ✅ `/login` shows the login form (not redirect)
- ✅ `/admin/dashboard` redirects to `/login` when not logged in
- ✅ After logging in, you can access `/admin/dashboard`
- ✅ No 404 errors anywhere

---

**Last Updated:** 2026-03-08  
**Commit:** ef30966
