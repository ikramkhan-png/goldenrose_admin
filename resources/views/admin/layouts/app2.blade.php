<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome TO Golden Rose Client's Dashboard</title>

@if(app()->getLocale() == 'ar')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
@else
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endif
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

.mobile-topbar{
display:none;
}

body{
background: #f0f4f8;
margin:0;
padding:0;
}

/* SIDEBAR */
 
.sidebar{
width:100%;
min-height:auto;
background:#1f2937;
display:flex;
flex-direction:column;
}
@media (min-width:768px){
.sidebar{
width:260px;
min-height:100vh;
}
}

.sidebar h4{
font-weight:600;
letter-spacing:1px;
}

.sidebar .nav-link{
color:#d1d5db !important;
padding:12px 15px;
margin-bottom:4px;
border-radius:6px;
font-size:14px;
transition:all .2s ease;
}

.sidebar .nav-link:hover{
background:#374151;
color:#fff !important;
}

.sidebar .nav-link.active{
background:#0d6efd;
color:#fff !important;
}

.sidebar-section{
font-size:11px;
letter-spacing:1px;
text-transform:uppercase;
color:#9ca3af;
margin-top:25px;
margin-bottom:10px;
padding-left:10px;
border-top:1px solid #374151;
padding-top:10px;
}

.sidebar-footer{
margin-top:auto;
font-size:12px;
color:#9ca3af;
border-top:1px solid #374151;
padding-top:15px;
line-height:1.6;
}

.sidebar-footer i{
margin-right:6px;
}

/* TABLE */

.table tbody tr:hover{
background-color:#f8f9fc !important;
}

.table th,
.table td{
font-size:15px;
color:#2c3e50;
font-weight:600;
padding:18px 16px !important;
}

@media (max-width:767.98px){
.mobile-topbar{
display:flex;
}
.sidebar{
display:none;
}
.sidebar.sidebar-visible{
display:block;
}
.table{
display:block;
width:100%;
overflow-x:auto;
-webkit-overflow-scrolling:touch;
}
.table thead,
.table tbody,
.table tr,
.table th,
.table td{
white-space:nowrap;
}
}

/* FORM */

.form-control,
.form-select{
border-color:#e8ecf1 !important;
background:#f8f9fc;
font-size:14px;
font-weight:500;
}

.form-control:focus,
.form-select:focus{
border-color:#667eea !important;
background:white;
box-shadow:0 0 0 .2rem rgba(102,126,234,.1) !important;
}

/* BUTTON */

.btn:hover{
transform:translateY(-2px);
box-shadow:0 4px 12px rgba(0,0,0,.15) !important;
}

/* HEADINGS */

h1,h2,h4{
color:#2c3e50;
}

/* CARDS */

.card{
transition:all .3s ease;
}

.card:hover{
transform:translateY(-2px);
}

/* ACTION BUTTONS */

.actions-cell{
white-space:nowrap;
}

.actions-cell .btn{
font-size:10px;
padding:2px 4px;
}

.table td .btn-sm{
font-size:10px !important;
padding:2px 4px !important;
transition:transform .15s ease;
}

.table td .btn-sm:hover{
transform:scale(1.3);
}

</style>
</head>

<body>
 
<div class="mobile-topbar d-md-none bg-dark text-white d-flex align-items-center justify-content-between px-3 py-2">
    <span class="fw-semibold">Golden Rose Client</span>
    <button class="btn btn-outline-light btn-sm" id="clientSidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
</div>

<div class="d-flex flex-column flex-md-row min-vh-100">

<!-- SIDEBAR -->

<aside class="sidebar text-white p-3">

<h4 class="text-center mb-4">{{ __('admin.golden_rose') }}</h4>

<!-- Language Switcher -->
<div class="dropdown mb-3">
    <button class="btn btn-outline-light btn-sm dropdown-toggle w-100" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-globe me-1"></i> {{ __('admin.language') }}: {{ app()->getLocale() == 'ar' ? __('admin.arabic') : __('admin.english') }}
    </button>
    <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
        <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">🇺🇸 {{ __('admin.english') }}</a></li>
        <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('language.switch', 'ar') }}">🇸🇦 {{ __('admin.arabic') }}</a></li>
    </ul>
</div>

<ul class="nav flex-column mt-3">

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}">
📊 {{ __('admin.dashboard') }}
</a>
</li>

<div class="sidebar-section">{{ app()->getLocale() == 'ar' ? 'عرض البيانات' : 'View Data' }}</div>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.projects.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=projects">
📁 {{ __('admin.projects') }}
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.services.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=services">
🛎️ {{ __('admin.services') }}
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.services.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=finance">
💰 {{ app()->getLocale() == 'ar' ? 'الملخص المالي' : 'Financial Summary' }}
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.messages.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=messages">
✉️ {{ app()->getLocale() == 'ar' ? 'رسائلي' : 'Messages' }}
</a>
</li>

<li class="nav-item mt-4">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="btn btn-outline-light w-100">
🚪 {{ __('admin.logout') }}
</button>
</form>
</li>

</ul>

<!-- FOOTER -->

<div class="sidebar-footer mt-4">

<div>
<i class="fa-solid fa-envelope"></i>
info@goldenroseconstructions.com
</div>

<div>
<i class="fa-solid fa-location-dot"></i>
Head Office Alhijaz Street  
Sharah Salam, Riyadh
</div>

<div class="mt-2">
© 2026 Golden Rose Constructions  
All Rights Reserved
</div>

 </div>

</aside>

<!-- MAIN CONTENT -->

<main class="flex-fill" style="overflow-x:hidden;">
@yield('content')
</main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('clientSidebarToggle');
    var sidebar = document.querySelector('.sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-visible');
        });
    }
});
</script>

</body>
</html>