<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Golden Rose Admin - Login' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7gy/lpuj7+BXi1xMjEFE1xq5q/5I2yXfEH5" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    @livewireStyles
    
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
            padding: 16px;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .login-header {
            background: #1a2535;
            color: white;
            padding: 36px 32px;
            text-align: center;
        }

        .login-header .logo {
            width: 72px;
            height: 72px;
            background: #4f46e5;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .login-header .logo i {
            font-size: 32px;
            color: #fff;
        }

        .login-header h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #f1f5f9;
        }

        .login-header p {
            font-size: 13px;
            color: #94a3b8;
            margin: 0;
        }

        .login-body {
            padding: 36px 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .form-control {
            display: block;
            width: 100%;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            padding: 12px 14px;
            font-size: 14px;
            border-radius: 8px;
            color: #1e293b;
            line-height: 1.5;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-control:focus {
            border-color: #4f46e5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            display: block;
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
        }

        .btn-login {
            background: #4f46e5;
            border: none;
            color: white;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #4338ca;
            color: white;
        }

        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .form-check-label {
            font-size: 13px;
            color: #64748b;
        }

        .forgot-link {
            color: #4f46e5;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        .login-footer {
            background: #f8fafc;
            padding: 16px 20px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .login-footer p {
            margin: 0;
            font-size: 12px;
            color: #94a3b8;
        }

        .alert {
            border-radius: 8px;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    @livewireScripts
</body>
</html>
