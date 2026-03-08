<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        // Get settings from cache, merge with defaults
        $cachedSettings = \Cache::get('app_settings', []);
        
        // Default settings
        $defaults = [
            // Company Settings
            'company_name' => config('app.name', 'Golden Rose'),
            'company_email' => env('COMPANY_EMAIL', 'admin@goldenrose.com'),
            'company_phone' => env('COMPANY_PHONE', '+1-555-0000'),
            'company_address' => env('COMPANY_ADDRESS', 'Your Company Address'),
            
            // System Settings
            'app_timezone' => config('app.timezone', 'UTC'),
            'app_locale' => config('app.locale', 'en'),
            'currency' => env('CURRENCY', 'USD'),
            
            // Email Settings
            'mail_from_name' => config('mail.from.name', 'Golden Rose'),
            'mail_from_address' => config('mail.from.address', 'noreply@goldenrose.com'),
            'mail_driver' => config('mail.default', 'smtp'),
            
            // Dashboard Settings
            'dashboard_refresh_interval' => env('DASHBOARD_REFRESH', 60),
            'items_per_page' => env('ITEMS_PER_PAGE', 15),
            
            // Notification Settings
            'enable_email_notifications' => env('ENABLE_EMAIL_NOTIFICATIONS', true),
            'enable_dashboard_alerts' => env('ENABLE_DASHBOARD_ALERTS', true),
            'notification_email' => env('NOTIFICATION_EMAIL', 'admin@goldenrose.com'),
            
            // Security Settings
            'enable_two_factor' => env('ENABLE_TWO_FACTOR', false),
            'session_timeout' => env('SESSION_TIMEOUT', 120),
            'password_expiry_days' => env('PASSWORD_EXPIRY_DAYS', 90),
            
            // Backup Settings
            'enable_auto_backup' => env('ENABLE_AUTO_BACKUP', true),
            'backup_frequency' => env('BACKUP_FREQUENCY', 'daily'),
            'backup_retention_days' => env('BACKUP_RETENTION_DAYS', 30),
        ];
        
        // Merge cached settings with defaults (cached takes precedence)
        $settings = array_merge($defaults, $cachedSettings);
        
        return view('admin.settings.index', ['settings' => $settings]);
    }

    /**
     * Update settings - validates only fields present in request & saves to cache
     */
    public function update(Request $request)
    {
        // Build validation rules dynamically based on submitted fields
        $rules = [];
        
        // Company Settings
        if ($request->has('company_name')) {
            $rules['company_name'] = 'required|string|max:255';
        }
        if ($request->has('company_email')) {
            $rules['company_email'] = 'required|email';
        }
        if ($request->has('company_phone')) {
            $rules['company_phone'] = 'required|string|max:20';
        }
        if ($request->has('company_address')) {
            $rules['company_address'] = 'required|string|max:255';
        }
        
        // System Settings
        if ($request->has('app_timezone')) {
            $rules['app_timezone'] = 'required|string|timezone';
        }
        if ($request->has('app_locale')) {
            $rules['app_locale'] = 'required|string|in:en,es,fr,de';
        }
        if ($request->has('currency')) {
            $rules['currency'] = 'required|string|size:3';
        }
        if ($request->has('items_per_page')) {
            $rules['items_per_page'] = 'required|integer|between:5,100';
        }
        if ($request->has('dashboard_refresh_interval')) {
            $rules['dashboard_refresh_interval'] = 'required|integer|between:15,300';
        }
        
        // Backup Settings
        if ($request->has('backup_frequency')) {
            $rules['backup_frequency'] = 'required|string|in:daily,weekly,monthly';
        }
        if ($request->has('backup_retention_days')) {
            $rules['backup_retention_days'] = 'required|integer|between:7,365';
        }
        
        // Boolean settings - no validation needed
        if ($request->has('enable_email_notifications')) {
            $rules['enable_email_notifications'] = 'boolean';
        }
        if ($request->has('enable_dashboard_alerts')) {
            $rules['enable_dashboard_alerts'] = 'boolean';
        }
        if ($request->has('enable_two_factor')) {
            $rules['enable_two_factor'] = 'boolean';
        }
        if ($request->has('enable_auto_backup')) {
            $rules['enable_auto_backup'] = 'boolean';
        }
        
        // Only validate if there are rules to check
        if (!empty($rules)) {
            $validated = $request->validate($rules);
        }
        
        // Get all current settings
        $settings = \Cache::get('app_settings', []);
        
        // Update settings with submitted values
        foreach ($request->all() as $key => $value) {
            if ($key !== '_token' && $key !== '_method') {
                $settings[$key] = $value;
            }
        }
        
        // Save settings to cache (expires after 1 year)
        \Cache::put('app_settings', $settings, now()->addYear());
        
        return redirect()->route('admin.settings.index')
            ->with('success', '✅ Settings updated successfully!');
    }

    /**
     * Clear application cache
     */
    public function clearCache()
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:cache');
            
            return redirect()->route('admin.settings.index')
                ->with('success', '✅ Cache cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', '❌ Cache clear failed: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application
     */
    public function optimize()
    {
        try {
            \Artisan::call('optimize:clear');
            \Artisan::call('config:cache');
            
            return redirect()->route('admin.settings.index')
                ->with('success', '✅ Application optimized successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', '❌ Optimization failed: ' . $e->getMessage());
        }
    }

    /**
     * Run database backup
     */
    public function backup()
    {
        try {
            // Create backup timestamp
            $timestamp = now()->format('Y-m-d_H-i-s');
            
            // Run backup command (if exists)
            if (class_exists('Spatie\DbDumper\DbDumper')) {
                \Artisan::call('backup:run');
                $message = 'Database backup created successfully!';
            } else {
                $message = 'Backup utility not configured';
            }
            
            return redirect()->route('admin.settings.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Test email configuration
     */
    public function testEmail()
    {
        try {
            \Mail::raw('This is a test email from Golden Rose Admin.', function ($message) {
                $message->to(env('COMPANY_EMAIL', 'admin@goldenrose.com'))
                    ->subject('Golden Rose - Email Configuration Test')
                    ->from(config('mail.from.address'));
            });
            
            return redirect()->route('admin.settings.index')
                ->with('success', 'Test email sent successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
