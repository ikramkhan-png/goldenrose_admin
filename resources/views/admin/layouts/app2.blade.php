<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome TO Golden Rose Client's Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

body{
background: linear-gradient(135deg,#f5f7fa 0%,#c3cfe2 100%);
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
 
<div class="d-flex flex-column flex-md-row min-vh-100">

<!-- SIDEBAR -->

<aside class="sidebar text-white p-3">

<h4 class="text-center mb-4">Golden Rose Client</h4>

<ul class="nav flex-column mt-3">

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}">
Dashboard
</a>
</li>

<div class="sidebar-section">View Data</div>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.projects.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=projects">
My Projects
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.services.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=services">
My Services
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.services.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=finance">
My services Financial Summary
</a>
</li>

<li class="nav-item">
<a class="nav-link {{ request()->routeIs('client.messages.*') ? 'active' : '' }}"
href="{{ route('client.dashboard') }}?tab=messages">
My Messages
</a>
</li>

<li class="nav-item mt-4">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="btn btn-outline-light w-100">
Logout
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

</body>
</html>