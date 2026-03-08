@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">

    {{-- PAGE HEADER --}}
    <x-page-header title="Project Dashboard" description="Comprehensive project management for internal operations including services, documents, billing, and expenses." />

    {{-- PROJECT HEADER CARD --}}
    <div class="card mb-4 border-0 shadow-sm p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold mb-2">{{ $project->name }}</h4>
                <p class="mb-2"><strong>Client:</strong> {{ $project->client->name }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Type:</strong> {{ ucfirst($project->type) }}</p>
                        <p class="mb-1"><strong>Start Date:</strong> {{ $project->start_date }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>End Date:</strong> {{ $project->end_date ?? '-' }}</p>
                        <p class="mb-1"><strong>Budget:</strong> {{ number_format($project->budget ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.clients.show', $project->client->id) }}" class="btn btn-light btn-sm">
                    ← Back to Client
                </a>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    @php $tab = request('tab', 'overview'); @endphp
    <div class="card mb-4 border-0 shadow-sm" style="background: white;">
        <div class="card-body p-3">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'overview' ? 'active' : '' }}" href="?tab=overview" style="font-size: 14px;">
                        <i class="bi bi-eye"></i> Overview
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'services' ? 'active' : '' }}" href="?tab=services" style="font-size: 14px;">
                        <i class="bi bi-briefcase"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'documents' ? 'active' : '' }}" href="?tab=documents" style="font-size: 14px;">
                        <i class="bi bi-file-text"></i> Documents
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'billing' ? 'active' : '' }}" href="?tab=billing" style="font-size: 14px;">
                        <i class="bi bi-receipt"></i> Billing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'expenses' ? 'active' : '' }}" href="?tab=expenses" style="font-size: 14px;">
                        <i class="bi bi-cash-coin"></i> Expenses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'calculations' ? 'active' : '' }}" href="?tab=calculations" style="font-size: 14px;">
                        <i class="bi bi-calculator"></i> Calculations
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- =========== OVERVIEW TAB =========== --}}
    @if($tab === 'overview')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);">
                <h6 class="fw-bold text-dark mb-3">📋 Project Details</h6>
                <p class="mb-2"><strong>Status:</strong> <span class="badge bg-primary">Active</span></p>
                <p class="mb-2"><strong>Type:</strong> {{ ucfirst($project->type) }}</p>
                <p class="mb-2"><strong>Budget:</strong> {{ number_format($project->budget ?? 0, 2) }}</p>
                <p class="mb-0"><strong>Notes:</strong> {{ $project->notes ?? 'No notes' }}</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #764ba215 0%, #667eea15 100%);">
                <h6 class="fw-bold text-dark mb-3">👤 Client Information</h6>
                <p class="mb-2"><strong>Name:</strong> {{ $project->client->name }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $project->client->email }}</p>
                <p class="mb-2"><strong>Phone:</strong> {{ $project->client->phone ?? '-' }}</p>
                <p class="mb-0"><strong>Type:</strong> {{ ucfirst($project->client->client_type ?? '-') }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- =========== SERVICES TAB =========== --}}
    @if($tab === 'services')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h6 class="fw-bold text-dark">📦 Assigned Services</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.project-services.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-plus"></i> Add Service
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Type</th>
                        <th>Rate Type</th>
                        <th style="text-align: right;">Duration</th>
                        <th style="text-align: right;">Rate</th>
                        <th style="text-align: right;">Total</th>
                        <th class="actions-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->assignedServices ?? [] as $service)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $service->service->name ?? '-' }}</td>
                            <td>{{ class_basename($service->service_type ?? '') }}</td>
                            <td>{{ $service->rate_type }}</td>
                            <td style="text-align: right;">{{ $service->duration }}</td>
                            <td style="text-align: right; font-weight: 600; color: #667eea;">{{ number_format($service->rate, 2) }}</td>
                            <td style="text-align: right; font-weight: 600; color: #28a745;">{{ number_format($service->total_cost, 2) }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.project-services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('admin.project-services.destroy', $service->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Delete this service?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">No services assigned</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- =========== DOCUMENTS TAB =========== --}}
    @if($tab === 'documents')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h6 class="fw-bold text-dark">📄 Project Documents</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.project-documents.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> Add Document
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>Project</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->documents ?? [] as $doc)
                        <tr>
                            <td>{{ $doc->project->name }}</td>
                            <td>{{ $doc->title }}</td>
                            <td>{{ ucfirst($doc->status) }}</td>
                            <td>{{ $doc->update_date }}</td>
                            <td>
                                @if($doc->file)
                                    <a href="{{ asset('storage/'.$doc->file) }}" target="_blank">View</a>
                                @endif
                            </td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.project-documents.edit', $doc->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.project-documents.destroy', $doc->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this document?')">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">No documents uploaded</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- =========== BILLING TAB =========== --}}
    @if($tab === 'billing')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h6 class="fw-bold text-dark">💰 Project Billing</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.project-billings.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus"></i> Add Invoice
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>#</th>
                        <th>Status</th>
                        <th style="text-align: right;">Amount Billed</th>
                        <th style="text-align: right;">Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Invoice File</th>
                        <th class="actions-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->billings ?? [] as $billing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-{{ $billing->status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($billing->status ?? 'pending') }}
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 600;">{{ number_format($billing->amount_billed ?? 0, 2) }}</td>
                            <td style="text-align: right; color: #28a745;">{{ number_format($billing->amount_paid ?? 0, 2) }}</td>
                            <td>{{ $billing->payment_date ? \Carbon\Carbon::parse($billing->payment_date)->format('M d, Y') : '-' }}</td>
                            <td>
                                @if($billing->invoice)
                                    <a href="{{ asset('storage/' . $billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark-pdf"></i> View
                                    </a>
                                @else
                                    <span class="text-muted small">No File</span>
                                @endif
                            </td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.project-billings.edit', $billing->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                
                                <!-- Fixed Delete Form -->
                                <form action="{{ route('admin.project-billings.destroy', $billing->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this invoice?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">No billing records found</td></tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
    @endif

    {{-- =========== EXPENSES TAB =========== --}}
    @if($tab === 'expenses')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h6 class="fw-bold text-dark">💸 Project Expenses</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.expenses.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-plus"></i> Add Expense
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th style="text-align: right;">Amount</th>
                        <th>Invoice</th>
                        <th>Date</th>
                        <th class="actions-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->expenses ?? [] as $expense)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($expense->description)
                                    <span title="{{ $expense->description }}" 
                                        data-bs-toggle="tooltip" 
                                        style="cursor: help; border-bottom: 1px dashed #667eea;">
                                        {{ \Illuminate\Support\Str::words($expense->description, 3, '...') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $expense->category ?? '-' }}</span></td>
                            <td style="text-align: right; font-weight: 600; color: #d9534f;">{{ number_format($expense->amount ?? 0, 2) }}</td>
                            <td>
                                @if($expense->invoice)
                                    <a href="{{ asset('storage/'.$expense->invoice) }}" target="_blank">View</a>
                                @endif
                            </td>
                            <td>{{ $expense->created_at?->format('M d, Y') }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('admin.expenses.destroy', $expense->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Delete this expense?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">No expenses recorded</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- =========== CALCULATIONS TAB =========== --}}
    @if($tab === 'calculations')
    @php
        // Get all calculations - Budget is the contract value, billings are additional invoices
        $budget = $project->budget ?? 0;
        $totalBilled = $project->billings ? $project->billings->sum('amount_billed') : 0;
        $totalPaid = $project->billings ? $project->billings->sum('amount_paid') : 0;
        
        // Total Contract Value = Budget + Additional Billings
        $totalContractValue = $budget + $totalBilled;
        
        // Service costs and expenses
        $serviceCost = $project->assignedServices ? $project->assignedServices->sum('total_cost') : 0;
        $totalExpenses = $project->expenses ? $project->expenses->sum('amount') : 0;
        
        // Total costs = Services + Expenses
        $totalCosts = $serviceCost + $totalExpenses;
        
        // Net Profit = Total Contract Value - Total Costs
        $netProfit = $totalContractValue - $totalCosts;
        
        // Remaining to be paid = Total Contract Value - Total Paid
        $remainingBalance = $totalContractValue - $totalPaid;
        
        // Budget utilization based on costs vs contract value
        $budgetUtilization = $totalContractValue > 0 ? ($totalCosts / $totalContractValue) * 100 : 0;
    @endphp
    
    <div class="row">
        {{-- TOTAL CONTRACT VALUE CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h6 class="fw-bold mb-2">💼 Total Contract Value</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalContractValue, 2) }}</h3>
                <p class="mb-0 small">Budget: {{ number_format($budget, 2) }} + Billed: {{ number_format($totalBilled, 2) }}</p>
            </div>
        </div>

        {{-- TOTAL PAID CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <h6 class="fw-bold mb-2">💵 Total Paid</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalPaid, 2) }}</h3>
                <p class="mb-0 small">Received from client</p>
            </div>
        </div>

        {{-- REMAINING BALANCE CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, {{ $remainingBalance > 0 ? '#f093fb 0%, #f5576c' : '#11998e 0%, #38ef7d' }} 100%); color: white;">
                <h6 class="fw-bold mb-2">⏳ Remaining Balance</h6>
                <h3 class="fw-bold mb-3">{{ number_format($remainingBalance, 2) }}</h3>
                <p class="mb-0 small">{{ $remainingBalance > 0 ? 'Due from client' : 'Fully paid' }}</p>
            </div>
        </div>

        {{-- NET PROFIT CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, {{ $netProfit >= 0 ? '#4facfe 0%, #00f2fe' : '#d9534f 0%, #c12c2c' }} 100%); color: white;">
                <h6 class="fw-bold mb-2">📈 Net Profit</h6>
                <h3 class="fw-bold mb-3">{{ number_format($netProfit, 2) }}</h3>
                <p class="mb-0 small">{{ $netProfit >= 0 ? 'Profit' : 'Loss' }}</p>
            </div>
        </div>
    </div>

    {{-- SECOND ROW - COSTS BREAKDOWN --}}
    <div class="row">
        {{-- SERVICES COST CARD --}}
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #333;">
                <h6 class="fw-bold mb-2">📦 Services Cost</h6>
                <h3 class="fw-bold mb-3">{{ number_format($serviceCost, 2) }}</h3>
                <p class="mb-0 small">Total service charges</p>
            </div>
        </div>

        {{-- TOTAL EXPENSES CARD --}}
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333;">
                <h6 class="fw-bold mb-2">💸 Total Expenses</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalExpenses, 2) }}</h3>
                <p class="mb-0 small">All project expenses</p>
            </div>
        </div>

        {{-- TOTAL COSTS CARD --}}
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333;">
                <h6 class="fw-bold mb-2">🧾 Total Costs</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalCosts, 2) }}</h3>
                <div class="progress" style="height: 5px; background: rgba(0,0,0,0.1);">
                    <div class="progress-bar bg-danger" style="width: {{ min($budgetUtilization, 100) }}%;"></div>
                </div>
                <p class="mb-0 small mt-2">{{ number_format($budgetUtilization, 1) }}% of contract value</p>
            </div>
        </div>
    </div>

    {{-- DETAILED CALCULATION BREAKDOWN --}}
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e8eaf6 100%);">
            <h6 class="fw-bold text-dark mb-4">🧮 Financial Breakdown</h6>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Revenue Calculation</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">Project Budget</td>
                            <td style="text-align: right; color: #667eea; font-weight: 600;">{{ number_format($budget, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">+ Additional Billings</td>
                            <td style="text-align: right; color: #667eea; font-weight: 600;">{{ number_format($totalBilled, 2) }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #667eea; background: rgba(102, 126, 234, 0.1);">
                            <td class="fw-bold" style="color: #667eea;">= TOTAL CONTRACT VALUE</td>
                            <td style="text-align: right; color: #667eea; font-weight: 700; font-size: 16px;">{{ number_format($totalContractValue, 2) }}</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-muted mb-3 mt-4">Payment Status</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">Total Paid by Client</td>
                            <td style="text-align: right; color: #28a745; font-weight: 600;">{{ number_format($totalPaid, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Remaining Balance</td>
                            <td style="text-align: right; color: {{ $remainingBalance > 0 ? '#d9534f' : '#28a745' }}; font-weight: 600;">{{ number_format($remainingBalance, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Profit Calculation</h6>
                    <table class="table table-sm">
                        <tr style="border-bottom: 2px solid #667eea;">
                            <td class="fw-bold">Total Contract Value</td>
                            <td style="text-align: right; color: #667eea; font-weight: 600;">{{ number_format($totalContractValue, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold" style="color: #d9534f;">- Services Cost</td>
                            <td style="text-align: right; color: #d9534f; font-weight: 600;">{{ number_format($serviceCost, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold" style="color: #d9534f;">- Total Expenses</td>
                            <td style="text-align: right; color: #d9534f; font-weight: 600;">{{ number_format($totalExpenses, 2) }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #667eea; border-bottom: 2px solid #667eea; background: rgba(102, 126, 234, 0.1);">
                            <td class="fw-bold" style="color: #667eea;">= NET PROFIT</td>
                            <td style="text-align: right; color: {{ $netProfit >= 0 ? '#28a745' : '#d9534f' }}; font-weight: 700; font-size: 16px;">{{ number_format($netProfit, 2) }}</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-muted mb-3 mt-4">Key Metrics</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">Cost Utilization</td>
                            <td style="text-align: right;">{{ number_format($budgetUtilization, 2) }}%</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Profit Margin</td>
                            <td style="text-align: right;">{{ $totalContractValue > 0 ? number_format(($netProfit / $totalContractValue) * 100, 2) : 0 }}%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ================= TAB SCRIPT ================= --}}
<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-section').forEach(sec => sec.classList.add('d-none'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('btn-dark'));
            document.getElementById(this.dataset.tab).classList.remove('d-none');
            this.classList.add('btn-dark');
        });
    });
</script>

{{-- ================= CUSTOM STYLES ================= --}}
<style>
    /* Hover effect on tables */
    table.table-hover tbody tr:hover {
        background-color: #f1f5f9;
        transition: background 0.2s ease-in-out;
    }

    /* Rounded table cells */
    table th, table td {
        vertical-align: middle;
    }

    /* Buttons shadow and hover */
    .btn-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.2s ease-in-out;
    }
</style>
@endsection