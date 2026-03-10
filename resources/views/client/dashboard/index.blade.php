<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Golden Rose Construction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        .section-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 25px;
        }
        .section-header {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        .section-header h5 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }
        .note-card {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .note-card.unread {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left-color: #28a745;
        }
        .update-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }
        .update-item:hover {
            background: #f8f9fa;
        }
        .update-item:last-child {
            border-bottom: none;
        }
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        .badge-service { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .badge-project { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .query-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .query-btn:hover {
            transform: scale(1.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: #667eea !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-building me-2"></i>Golden Rose Construction
            </a>
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted">Welcome, {{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2"><i class="fas fa-tachometer-alt me-2"></i>Welcome to Your Dashboard</h2>
                    <p class="mb-0 opacity-75">View your services, projects, and important updates from Golden Rose Construction</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="fas fa-user me-1"></i>{{ ucfirst($user->client_type ?? 'General') }} Client
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div>
                            <small class="text-muted">Assigned Services</small>
                            <h4 class="mb-0">{{ $services->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon me-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <div>
                            <small class="text-muted">Active Projects</small>
                            <h4 class="mb-0">{{ $projects->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon me-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <small class="text-muted">Total Contract</small>
                            <h4 class="mb-0">{{ number_format($totalContractValue, 0) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon me-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <small class="text-muted">Balance Due</small>
                            <h4 class="mb-0 {{ $totalRemaining > 0 ? 'text-warning' : 'text-success' }}">
                                {{ number_format($totalRemaining, 0) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notes Section -->
        @if($importantNotes->count() > 0)
        <div class="section-card">
            <div class="section-header">
                <h5><i class="fas fa-bell me-2 text-warning"></i>Important Notes from Admin</h5>
            </div>
            <div class="card-body p-3">
                @foreach($importantNotes as $note)
                    <div class="note-card {{ !$note->is_read ? 'unread' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">
                                    @if(!$note->is_read)
                                        <span class="badge bg-success me-2">New</span>
                                    @endif
                                    {{ $note->subject }}
                                </h6>
                                <p class="mb-2">{{ $note->message }}</p>
                                @if($note->document)
                                    <a href="{{ asset('storage/'.$note->document) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-paperclip"></i> View Attachment
                                    </a>
                                @endif
                            </div>
                            <div class="text-end">
                                <small class="text-muted">{{ $note->created_at->format('M d, Y') }}</small>
                                @if(!$note->is_read)
                                    <form action="{{ route('client.note.read', $note->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-muted">Mark as read</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- ===== SERVICES SECTION WITH TABS ===== -->
        <div class="section-card mb-4">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-cogs me-2 text-primary"></i>My Services</h5>
                <span class="badge badge-service">{{ $services->count() }} Services</span>
            </div>
            
            <ul class="nav nav-tabs px-3 pt-3" id="servicesTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="services-list-tab" data-bs-toggle="tab" data-bs-target="#services-list" type="button" role="tab">
                        <i class="fas fa-list me-1"></i> Services List
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="services-finance-tab" data-bs-toggle="tab" data-bs-target="#services-finance" type="button" role="tab">
                        <i class="fas fa-calculator me-1"></i> Finance
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="servicesTabContent">
                <div class="tab-pane fade show active" id="services-list" role="tabpanel">
                    @if($services->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service Name</th>
                                        <th>Type</th>
                                        <th>Rate Type</th>
                                        <th>Duration</th>
                                        <th>Rate</th>
                                        <th class="text-end">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $index => $service)
                                        @php
                                            if($service->hours > 0) {
                                                $rateType = 'Hourly';
                                                $duration = $service->hours . ' hrs';
                                                $rate = $service->hourly_rate;
                                                $amount = $service->hours * $service->hourly_rate;
                                            } elseif($service->days > 0) {
                                                $rateType = 'Daily';
                                                $duration = $service->days . ' days';
                                                $rate = $service->daily_rate;
                                                $amount = $service->days * $service->daily_rate;
                                            } else {
                                                $rateType = 'Monthly';
                                                $duration = $service->months . ' months';
                                                $rate = $service->monthly_rate;
                                                $amount = $service->months * $service->monthly_rate;
                                            }
                                            $serviceType = class_basename($service->service_type ?? '');
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $service->service->name ?? '-' }}</strong></td>
                                            <td><span class="badge bg-info">{{ $serviceType }}</span></td>
                                            <td><span class="badge bg-secondary">{{ $rateType }}</span></td>
                                            <td>{{ $duration }}</td>
                                            <td>{{ number_format($rate, 2) }}</td>
                                            <td class="text-end fw-bold text-primary">{{ number_format($amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="6" class="text-end fw-bold">Total Service Amount:</td>
                                        <td class="text-end fw-bold text-success">{{ number_format($totalServiceAmount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>No services assigned yet</p>
                        </div>
                    @endif
                </div>
                
                <div class="tab-pane fade" id="services-finance" role="tabpanel">
                    <div class="row g-3 p-3">
                        <div class="col-md-4">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <small class="opacity-75">Total Service Amount</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalServiceAmount, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <small class="opacity-75">Total Paid</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalServicePaid, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <small class="opacity-75">Remaining Balance</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalServiceRemaining, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-3 pb-3">
                        <h6 class="fw-bold mb-3"><i class="fas fa-file-invoice me-2"></i>Payment History</h6>
                        @php $allServiceBillings = $services->flatMap(fn($s) => $s->billings); @endphp
                        @if($allServiceBillings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Date</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allServiceBillings as $index => $billing)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="fw-bold text-success">{{ number_format($billing->amount_paid, 2) }}</td>
                                                <td>{{ $billing->payment_date ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $billing->status == 'paid' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($billing->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $billing->notes ?? '-' }}</td>
                                                <td>
                                                    @if($billing->invoice)
                                                        <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-receipt fa-2x mb-2"></i>
                                <p class="mb-0">No payment records yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== PROJECTS SECTION WITH TABS ===== -->
        <div class="section-card mb-4">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-project-diagram me-2 text-success"></i>My Projects</h5>
                <span class="badge badge-project">{{ $projects->count() }} Projects</span>
            </div>
            
            <ul class="nav nav-tabs px-3 pt-3" id="projectsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="projects-list-tab" data-bs-toggle="tab" data-bs-target="#projects-list" type="button" role="tab">
                        <i class="fas fa-list me-1"></i> Projects List
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="projects-finance-tab" data-bs-toggle="tab" data-bs-target="#projects-finance" type="button" role="tab">
                        <i class="fas fa-calculator me-1"></i> Finance
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="projects-documents-tab" data-bs-toggle="tab" data-bs-target="#projects-documents" type="button" role="tab">
                        <i class="fas fa-file-alt me-1"></i> Documents
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="projectsTabContent">
                <div class="tab-pane fade show active" id="projects-list" role="tabpanel">
                    @if($projects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Project Name</th>
                                        <th>Type</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th class="text-end">Budget</th>
                                        <th class="text-end">Paid</th>
                                        <th class="text-end">Remaining</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $index => $project)
                                        @php
                                            $projectBilled = $project->billings->sum('amount_billed');
                                            $projectPaid = $project->billings->sum('amount_paid');
                                            $projectTotal = $project->budget + $projectBilled;
                                            $projectRemaining = $projectTotal - $projectPaid;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $project->name }}</strong></td>
                                            <td><span class="badge bg-info">{{ ucfirst($project->type) }}</span></td>
                                            <td>{{ $project->start_date ?? '-' }}</td>
                                            <td>{{ $project->end_date ?? '-' }}</td>
                                            <td class="text-end">{{ number_format($projectTotal, 2) }}</td>
                                            <td class="text-end fw-bold text-success">{{ number_format($projectPaid, 2) }}</td>
                                            <td class="text-end fw-bold {{ $projectRemaining > 0 ? 'text-warning' : 'text-success' }}">{{ number_format($projectRemaining, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-end fw-bold">Total:</td>
                                        <td class="text-end fw-bold">{{ number_format($totalContractValue, 2) }}</td>
                                        <td class="text-end fw-bold text-success">{{ number_format($totalProjectPaid, 2) }}</td>
                                        <td class="text-end fw-bold text-warning">{{ number_format($totalRemaining, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                            <p>No projects assigned yet</p>
                        </div>
                    @endif
                </div>
                
                <div class="tab-pane fade" id="projects-finance" role="tabpanel">
                    <div class="row g-3 p-3">
                        <div class="col-md-3">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <small class="opacity-75">Total Budget</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalProjectBudget, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <small class="opacity-75">Additional Billings</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalProjectBilled, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <small class="opacity-75">Total Paid</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalProjectPaid, 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 text-white p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <small class="opacity-75">Remaining Balance</small>
                                <h4 class="mb-0 fw-bold">{{ number_format($totalRemaining, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-3 pb-3">
                        <h6 class="fw-bold mb-3"><i class="fas fa-file-invoice me-2"></i>Payment History</h6>
                        @php $allProjectBillings = $projects->flatMap(fn($p) => $p->billings->map(fn($b) => $b->setAttribute('project_name', $p->name))); @endphp
                        @if($allProjectBillings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Project</th>
                                            <th>Amount Billed</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Date</th>
                                            <th>Status</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allProjectBillings as $index => $billing)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $billing->project_name }}</td>
                                                <td>{{ number_format($billing->amount_billed, 2) }}</td>
                                                <td class="fw-bold text-success">{{ number_format($billing->amount_paid, 2) }}</td>
                                                <td>{{ $billing->payment_date ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $billing->status == 'paid' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($billing->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($billing->invoice)
                                                        <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-receipt fa-2x mb-2"></i>
                                <p class="mb-0">No payment records yet</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="tab-pane fade" id="projects-documents" role="tabpanel">
                    <div class="p-3">
                        @if($projectUpdates->count() > 0)
                            @foreach($projectUpdates as $update)
                                <div class="update-item border rounded p-3 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">
                                                <span class="badge bg-info me-2">{{ $update->project->name ?? 'Project' }}</span>
                                                {{ $update->title }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $update->created_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                        @if($update->file)
                                            <a href="{{ asset('storage/'.$update->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-file-alt fa-2x mb-2"></i>
                                <p class="mb-0">No documents uploaded yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- My Queries Section -->
        @if($myQueries->count() > 0)
        <div class="section-card">
            <div class="section-header">
                <h5><i class="fas fa-question-circle me-2 text-purple"></i>My Queries</h5>
            </div>
            <div class="card-body">
                @foreach($myQueries as $query)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $query->subject }}</h6>
                                <p class="text-muted mb-2">{{ $query->message }}</p>
                                @if($query->admin_reply)
                                    <div class="bg-light p-2 rounded mt-2">
                                        <small class="text-muted">Admin Reply:</small>
                                        <p class="mb-0">{{ $query->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                            <span class="badge bg-{{ $query->status == 'resolved' ? 'success' : 'warning' }}">
                                {{ ucfirst($query->status) }}
                            </span>
                        </div>
                        <small class="text-muted">Submitted: {{ $query->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Contact Support Section -->
        <div class="section-card">
            <div class="section-header">
                <h5><i class="fas fa-headset me-2 text-primary"></i>Need Help?</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">If you have any questions or need assistance, please don't hesitate to reach out to us.</p>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone fa-2x text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Phone</small>
                                <p class="mb-0 fw-bold">+92 300 1234567</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope fa-2x text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <p class="mb-0 fw-bold">support@goldenrose.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-3"></i>
                            <div>
                                <small class="text-muted">Office</small>
                                <p class="mb-0 fw-bold">Lahore, Pakistan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Query Button -->
    <button class="query-btn" data-bs-toggle="modal" data-bs-target="#queryModal" title="Submit a Query">
        <i class="fas fa-comment-dots"></i>
    </button>

    <!-- Query Modal -->
    <div class="modal fade" id="queryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i>Submit a Query</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('client.query.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control" required placeholder="What is your query about?">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="4" required placeholder="Describe your query in detail..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Attachment (Optional)</label>
                            <input type="file" name="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <small class="text-muted">Allowed: PDF, JPG, PNG, DOC (Max 5MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Submit Query
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
