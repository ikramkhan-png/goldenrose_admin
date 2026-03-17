@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">

    @php $tab = request('tab', 'overview'); @endphp
    
    {{-- PAGE HEADER --}}
    <x-page-header title="{{ __('projects.project_dashboard') }}" description="{{ __('projects.page_description') }}" />

    {{-- PROJECT HEADER CARD --}}
    <div class="card mb-4 border-0 shadow-sm p-4" style="background: #4f46e5; color: white;">
        <div class="row">
            <div class="col-md-8">
                <h4 class="fw-bold mb-2">{{ $project->name }}</h4>
                <p class="mb-2"><strong>{{ __('projects.client') }}:</strong> {{ $project->client->name }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>{{ __('projects.type') }}:</strong> {{ ucfirst($project->type) }}</p>
                        <p class="mb-1"><strong>{{ __('projects.start_date') }}:</strong> {{ $project->start_date }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>{{ __('projects.end_date') }}:</strong> {{ $project->end_date ?? '-' }}</p>
                        <p class="mb-1"><strong>{{ __('projects.budget') }}:</strong> {{ number_format($project->budget ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.clients.show', $project->client->id) }}" class="btn btn-light btn-sm">
                    {{ __('projects.back_to_client') }}
                </a>
            </div>
        </div>
    </div>

    {{-- ===== MONTH FILTER ===== --}}
    <div class="card mb-4" style="background: white;">
        <div class="card-body p-4">
            <form action="{{ request()->url() }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">📅 {{ __('projects.filter_by_month') }}</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">📆 {{ __('projects.filter') }}</label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('projects.show_all') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 120px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">&nbsp;</label>
                    <a href="{{ request()->url() }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> {{ __('projects.show_all') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <div class="card mb-4 border-0 shadow-sm" style="background: white;">
        <div class="card-body p-3">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'overview' ? 'active' : '' }}" href="?tab=overview{{ request('month') ? '&month=' . request('month') : '' }}" style="font-size: 14px;">
                        <i class="bi bi-eye"></i> {{ __('projects.overview') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'services' ? 'active' : '' }}" href="?tab=services{{ request('month') ? '&month=' . request('month') : '' }}" style="font-size: 14px;">
                        <i class="bi bi-briefcase"></i> {{ __('projects.services') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'documents' ? 'active' : '' }}" href="?tab=documents{{ request('month') ? '&month=' . request('month') : '' }}" style="font-size: 14px;">
                        <i class="bi bi-file-text"></i> {{ __('projects.documents') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'billing' ? 'active' : '' }}" href="?tab=billing{{ request('month') ? '&month=' . request('month') : '' }}" style="font-size: 14px;">
                        <i class="bi bi-receipt"></i> {{ __('projects.billing') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'expenses' ? 'active' : '' }}" href="?tab=expenses{{ request('month') ? '&month=' . request('month') : '' }}" style="font-size: 14px;">
                        <i class="bi bi-cash-coin"></i> {{ __('projects.expenses') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ $tab === 'calculations' ? 'active' : '' }}" href="?tab=calculations{{ request('month') ? '&month=' . request('month') : '' }}" style="font-size: 14px;">
                        <i class="bi bi-calculator"></i> {{ __('projects.calculations') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- =========== OVERVIEW TAB =========== --}}
    @if($tab === 'overview')
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: #eff6ff;">
                <h4 class="fw-bold mb-2">{{ __('projects.project_details') }}</h4>
                <p class="mb-2"><strong>{{ __('projects.status') }}:</strong> <span class="badge bg-primary">Active</span></p>
                <p class="mb-2"><strong>Type:</strong> {{ ucfirst($project->type) }}</p>
                <p class="mb-2"><strong>Budget:</strong> {{ number_format($project->budget ?? 0, 2) }}</p>
                <p class="mb-0"><strong>{{ __('projects.notes') }}:</strong> {{ $project->notes ?? 'No notes' }}</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: #f5f3ff;">
                <h6 class="fw-bold text-dark mb-4">{{ __('projects.client_information') }}</h6>
                <p class="mb-2"><strong>{{ __('projects.name') }}:</strong> {{ $project->client->name }}</p>
                <p class="mb-2"><strong>{{ __('projects.email') }}:</strong> {{ $project->client->email }}</p>
                <p class="mb-2"><strong>{{ __('projects.phone') }}:</strong> {{ $project->client->phone ?? '-' }}</p>
                <p class="mb-0"><strong>{{ __('projects.client_type') }}:</strong> {{ ucfirst($project->client->client_type ?? '-') }}</p>
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
                    <h6 class="fw-bold text-dark">📦 {{ __('projects.assigned_services') }}</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.project-services.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-info">
                        <i class="bi bi-plus"></i> {{ __('projects.add_service') }}
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>#</th>
                        <th>{{ __('common.service') }}</th>
                        <th>{{ __('common.type') }}</th>
                        <th>{{ __('client_services.rate_type') }}</th>
                        <th style="text-align: right;">{{ __('client_services.duration') }}</th>
                        <th style="text-align: right;">{{ __('client_services.rate') }}</th>
                        <th style="text-align: right;">{{ __('common.total') }}</th>
                        <th>{{ __('client_services.assigned_date') }}</th>
                        <th class="actions-cell">{{ __('common.actions') }}</th>
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
                            <td>{{ $service->assigned_date ?? '-' }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.project-services.edit', $service->id) }}" class="btn btn-sm btn-warning">{{ __('common.edit') }}</a>
                                <a href="{{ route('admin.project-services.destroy', $service->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('common.delete_this_service') }}?')">{{ __('common.delete') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">{{ __('projects.no_services_assigned') }}</td></tr>
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
                    <h6 class="fw-bold text-dark">📄 {{ __('projects.documents') }}</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.project-documents.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> {{ __('projects.add_document') }}
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>{{ __('projects.project') }}</th>
                        <th>{{ __('projects.title') }}</th>
                        <th>{{ __('projects.status') }}</th>
                        <th>{{ __('projects.date') }}</th>
                        <th>{{ __('projects.file') }}</th>
                        <th>{{ __('projects.action') }}</th>
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
                        <tr><td colspan="6" class="text-center text-muted">{{ __('projects.no_documents_uploaded') }}</td></tr>
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
                    <h6 class="fw-bold text-dark">💰 {{ __('projects.billing') }}</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.project-billings.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus"></i> {{ __('projects.add_invoice') }}
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>#</th>
                        <th>{{ __('projects.status') }}</th>
                        <th style="text-align: right;">{{ __('projects.amount_billed') }}</th>
                        <th style="text-align: right;">{{ __('projects.amount_paid') }}</th>
                        <th>{{ __('projects.payment_date') }}</th>
                        <th>{{ __('projects.invoice_file') }}</th>
                        <th class="actions-cell">{{ __('projects.actions') }}</th>
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
                        <tr><td colspan="7" class="text-center text-muted">{{ __('projects.no_billing_records_found') }}</td></tr>
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
                    <h6 class="fw-bold text-dark">💸 {{ __('projects.expenses') }}</h6>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.expenses.create', ['project_id' => $project->id]) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-plus"></i> {{ __('projects.add_expense') }}
                    </a>
                </div>
            </div>
            <table class="table table-hover">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                    <tr>
                        <th>#</th>
                        <th>{{ __('projects.description') }}</th>
                        <th>{{ __('projects.category') }}</th>
                        <th style="text-align: right;">{{ __('projects.amount') }}</th>
                        <th>{{ __('projects.invoice') }}</th>
                        <th>{{ __('projects.date') }}</th>
                        <th class="actions-cell">{{ __('projects.actions') }}</th>
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
                        <tr><td colspan="7" class="text-center text-muted">{{ __('projects.no_expenses_recorded') }}</td></tr>
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
            <div class="card border-0 shadow-sm p-4" style="background: #4f46e5; color: white;">
                <h6 class="fw-bold mb-2">💼 {{ __('projects.total_contract_value') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalContractValue, 2) }}</h3>
                <p class="mb-0 small">{{ __('projects.budget') }}: {{ number_format($budget, 2) }} + {{ __('projects.billed') }}: {{ number_format($totalBilled, 2) }}</p>
            </div>
        </div>

        {{-- TOTAL PAID CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: #059669; color: white;">
                <h6 class="fw-bold mb-2">💵 {{ __('projects.total_paid') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalPaid, 2) }}</h3>
                <p class="mb-0 small">{{ __('projects.received_from_client') }}</p>
            </div>
        </div>

        {{-- REMAINING BALANCE CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: {{ $remainingBalance > 0 ? '#dc2626' : '#059669' }}; color: white;">
                <h6 class="fw-bold mb-2">⏳ {{ __('projects.remaining_balance') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($remainingBalance, 2) }}</h3>
                <p class="mb-0 small">{{ $remainingBalance > 0 ? __('projects.due_from_client') : __('projects.fully_paid') }}</p>
            </div>
        </div>

        {{-- NET PROFIT CARD --}}
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: {{ $netProfit >= 0 ? '#0284c7' : '#dc2626' }}; color: white;">
                <h6 class="fw-bold mb-2">📈 {{ __('projects.net_profit') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($netProfit, 2) }}</h3>
                <p class="mb-0 small">{{ $netProfit >= 0 ? __('projects.profit') : __('projects.loss') }}</p>
            </div>
        </div>
    </div>

    {{-- SECOND ROW - COSTS BREAKDOWN --}}
    <div class="row">
        {{-- SERVICES COST CARD --}}
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: #fdf2f8; color: #1e293b;">
                <h6 class="fw-bold mb-2">📦 {{ __('projects.services_cost') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($serviceCost, 2) }}</h3>
                <p class="mb-0 small">{{ __('projects.total_service_charges') }}</p>
            </div>
        </div>

        {{-- TOTAL EXPENSES CARD --}}
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: #f0fdfa; color: #1e293b;">
                <h6 class="fw-bold mb-2">💸 {{ __('projects.total_expenses') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalExpenses, 2) }}</h3>
                <p class="mb-0 small">{{ __('projects.all_project_expenses') }}</p>
            </div>
        </div>

        {{-- TOTAL COSTS CARD --}}
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4" style="background: #fff7ed; color: #1e293b;">
                <h6 class="fw-bold mb-2">🧾 {{ __('projects.total_costs') }}</h6>
                <h3 class="fw-bold mb-3">{{ number_format($totalCosts, 2) }}</h3>
                <div class="progress" style="height: 5px; background: rgba(0,0,0,0.1);">
                    <div class="progress-bar bg-danger" style="width: {{ min($budgetUtilization, 100) }}%;"></div>
                </div>
                <p class="mb-0 small mt-2">{{ number_format($budgetUtilization, 1) }}{{ __('projects.of_contract_value') }}</p>
            </div>
        </div>
    </div>

    {{-- DETAILED CALCULATION BREAKDOWN --}}
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-4" style="background: #f8fafc;">
            <h6 class="fw-bold text-dark">🧮 {{ __('projects.calculations') }}</h6>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">{{ __('projects.revenue_calculation') }}</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">{{ __('projects.project_budget') }}</td>
                            <td style="text-align: right; color: #667eea; font-weight: 600;">{{ number_format($budget, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('projects.billed') }}</td>
                            <td style="text-align: right; color: #667eea; font-weight: 600;">{{ number_format($totalBilled, 2) }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #667eea; background: rgba(102, 126, 234, 0.1);">
                            <td class="fw-bold" style="color: #667eea;">= {{ __('projects.total_contract_value') }}</td>
                            <td style="text-align: right; color: #667eea; font-weight: 700; font-size: 16px;">{{ number_format($totalContractValue, 2) }}</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-muted mb-3">{{ __('projects.payment_status') }}</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">{{ __('projects.total_paid') }}</td>
                            <td style="text-align: right; color: #28a745; font-weight: 600;">{{ number_format($totalPaid, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('projects.remaining_balance') }}</td>
                            <td style="text-align: right; color: {{ $remainingBalance > 0 ? '#d9534f' : '#28a745' }}; font-weight: 600;">{{ number_format($remainingBalance, 2) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">{{ __('projects.profit_calculation') }}</h6>
                    <table class="table table-sm">
                        <tr style="border-bottom: 2px solid #667eea;">
                            <td class="fw-bold">{{ __('projects.total_contract_value') }}</td>
                            <td style="text-align: right; color: #667eea; font-weight: 600;">{{ number_format($totalContractValue, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('projects.services_cost') }}</td>
                            <td style="text-align: right; color: #d9534f; font-weight: 600;">{{ number_format($serviceCost, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold" style="color: #d9534f;">- {{ __('projects.total_expenses') }}</td>
                            <td style="text-align: right; color: #d9534f; font-weight: 600;">{{ number_format($totalExpenses, 2) }}</td>
                        </tr>
                        <tr style="border-top: 2px solid #667eea; border-bottom: 2px solid #667eea; background: rgba(102, 126, 234, 0.1);">
                            <td class="fw-bold" style="color: #667eea;">= {{ __('projects.total_costs') }}</td>
                            <td style="text-align: right; color: #667eea; font-weight: 700; font-size: 16px;">{{ number_format($totalCosts, 2) }}</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-muted mb-3 mt-4">{{ __('projects.key_metrics') }}</h6>
                    <table class="table table-sm">
                        <tr>
                            <td class="fw-bold">{{ __('projects.cost_utilization') }}</td>
                            <td style="text-align: right;">{{ number_format($budgetUtilization, 2) }}%</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ __('projects.profit_margin') }}</td>
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

    /* Buttons */
    .btn-shadow:hover {
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
</style>
@endsection