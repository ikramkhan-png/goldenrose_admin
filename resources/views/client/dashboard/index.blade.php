@extends('admin.layouts.app2')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@php $tab = request('tab', 'services'); @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- ===== INTRO TEXT ===== --}}
    <div class="card mb-4 p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
        <h5 class="mb-2">{{ __('client.welcome_client') }}, {{ $user->name }}</h5>
        <p class="mb-0" style="opacity: 0.9;">{{ __('client.client_dashboard_subtitle') }}</p>
    </div>

    {{-- ===== CLIENT INFO ===== --}}
    <div class="card mb-4 p-3">
        <div class="row">
            <div class="col-md-3"><strong>{{ __('client.email') }}:</strong> {{ $user->email }}</div>
            <div class="col-md-3"><strong>{{ __('client.phone') }}:</strong> {{ $user->phone ?? '-' }}</div>
            <div class="col-md-3"><strong>{{ __('client.client_type') }}:</strong> {{ ucfirst($user->client_type ?? 'General') }}</div>
            <div class="col-md-3 text-end">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> {{ __('client.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== MONTH FILTER ===== --}}
    <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-4">
            <form action="{{ route('client.dashboard') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('admin.filter_by_month') }}</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('admin.filter') }}</label>
                    <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 120px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">&nbsp;</label>
                    <a href="{{ route('client.dashboard') }}?tab={{ $tab }}" class="btn btn-outline-secondary w-100" style="padding: 12px 14px; border: 2px solid #6c757d; border-radius: 8px; font-weight: 500; font-size: 14px;">
                        <i class="fas fa-times"></i> {{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ===== TOP TABS ===== --}}
    <div class="mb-3">
        <a href="{{ route('client.dashboard') }}?tab=services{{ request('month') ? '&month=' . request('month') : '' }}"
           class="btn btn-sm {{ $tab === 'services' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-cogs me-1"></i> {{ __('client.my_services') }}
        </a>
        <a href="{{ route('client.dashboard') }}?tab=projects{{ request('month') ? '&month=' . request('month') : '' }}"
           class="btn btn-sm {{ $tab === 'projects' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-project-diagram me-1"></i> {{ __('client.my_projects') }}
        </a>
        <a href="{{ route('client.dashboard') }}?tab=finance{{ request('month') ? '&month=' . request('month') : '' }}"
           class="btn btn-sm {{ $tab === 'finance' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-calculator me-1"></i> {{ __('client.finance_summary') }}
        </a>
        <a href="{{ route('client.dashboard') }}?tab=messages{{ request('month') ? '&month=' . request('month') : '' }}"
           class="btn btn-sm {{ $tab === 'messages' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-envelope me-1"></i> {{ __('client.messages') }}
        </a>
    </div>

    {{-- ================= SERVICES TAB ================= --}}
    @if($tab === 'services')
        {{-- MONTH FILTER FOR SERVICES --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('client.dashboard') }}?tab=services" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                    <input type="hidden" name="tab" value="services">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('client.filter_by_month') }}</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                               onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('client.filter') }}</label>
                        <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                            {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                        </div>
                    </div>
                    @if(request('month'))
                    <div style="min-width: 120px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">&nbsp;</label>
                        <a href="{{ route('client.dashboard') }}?tab=services" class="btn btn-outline-secondary w-100" style="padding: 12px 14px; border: 2px solid #6c757d; border-radius: 8px; font-weight: 500; font-size: 14px;">
                            <i class="fas fa-times"></i> {{ __('Show All') }}
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        @php
            $totalServiceAmount = 0;
            foreach($services as $svc) {
                if($svc->hours > 0) {
                    $totalServiceAmount += $svc->hours * $svc->hourly_rate;
                } elseif($svc->days > 0) {
                    $totalServiceAmount += $svc->days * $svc->daily_rate;
                } else {
                    $totalServiceAmount += $svc->months * $svc->monthly_rate;
                }
            }
        @endphp

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">{{ __('client.total_service_amount') }}</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalServiceAmount, 2) }}</h3>
                        </div>
                        <i class="fas fa-calculator fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">{{ __('client.total_services') }}</small>
                            <h3 class="mb-0 fw-bold">{{ $services->count() }}</h3>
                        </div>
                        <i class="fas fa-cogs fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">{{ __('client.total_paid') }}</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalServicePaid, 2) }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>{{ __('client.assigned_services') }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('client.service') }}</th>
                            <th>{{ __('client.rate_type') }}</th>
                            <th>{{ __('client.duration') }}</th>
                            <th>{{ __('client.rate') }}</th>
                            <th>{{ __('client.total_amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($services as $service)
                        @php
                            if($service->hours > 0) {
                                $rateType = __('client.hourly');
                                $duration = $service->hours . ' ' . __('client.hrs');
                                $rate = $service->hourly_rate;
                                $amount = $service->hours * $service->hourly_rate;
                            } elseif($service->days > 0) {
                                $rateType = __('client.daily');
                                $duration = $service->days . ' ' . __('client.days');
                                $rate = $service->daily_rate;
                                $amount = $service->days * $service->daily_rate;
                            } else {
                                $rateType = __('client.monthly');
                                $duration = $service->months . ' ' . __('client.months');
                                $rate = $service->monthly_rate;
                                $amount = $service->months * $service->monthly_rate;
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $service->service->name ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $rateType }}</span></td>
                            <td>{{ $duration }}</td>
                            <td>{{ number_format($rate, 2) }}</td>
                            <td class="fw-bold text-primary">{{ number_format($amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">{{ __('client.no_services_assigned') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ================= PROJECTS TAB ================= --}}
    @if($tab === 'projects')
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">{{ __('client.total_projects') }}</small>
                            <h3 class="mb-0 fw-bold">{{ $projects->count() }}</h3>
                        </div>
                        <i class="fas fa-project-diagram fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">{{ __('client.total_budget') }}</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalProjectBudget, 2) }}</h3>
                        </div>
                        <i class="fas fa-money-bill fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">{{ __('client.total_paid') }}</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalProjectPaid, 2) }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>{{ __('client.assigned_projects') }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('client.project_name') }}</th>
                            <th>{{ __('client.type') }}</th>
                            <th>{{ __('client.budget') }}</th>
                            <th>{{ __('client.start_date') }}</th>
                            <th>{{ __('client.end_date') }}</th>
                            <th>{{ __('client.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->name }}</td>
                            <td><span class="badge bg-info">{{ __('client.' . $project->type . '_type') }}</span></td>
                            <td>{{ number_format($project->budget ?? 0, 2) }}</td>
                            <td>{{ $project->start_date }}</td>
                            <td>{{ $project->end_date ?? '-' }}</td>
                            <td>
                                <a href="{{ route('client.project.show', $project->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> {{ __('client.view_details') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">{{ __('client.no_projects_assigned') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ================= FINANCE TAB ================= --}}
    @if($tab === 'finance')
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <small class="opacity-75">{{ __('client.total_service_amount') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalServiceAmount, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <small class="opacity-75">{{ __('client.total_project_budget') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalContractValue, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <small class="opacity-75">{{ __('client.total_paid') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalServicePaid + $totalProjectPaid, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <small class="opacity-75">{{ __('client.remaining_balance') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalServiceRemaining + $totalRemaining, 2) }}</h4>
                </div>
            </div>
        </div>

        {{-- Service Payments --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
                <strong><i class="fas fa-cogs me-2"></i>{{ __('client.service_payment_history') }}</strong>
            </div>
            <div class="table-responsive">
                @php $allServiceBillings = $services->flatMap(fn($s) => $s->billings); @endphp
                @if($allServiceBillings->count() > 0)
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('client.amount_paid') }}</th>
                                <th>{{ __('client.payment_date') }}</th>
                                <th>{{ __('client.status') }}</th>
                                <th>{{ __('client.notes') }}</th>
                                <th>{{ __('client.invoice') }}</th>
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
                                            {{ __('client.' . $billing->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $billing->notes ?? '-' }}</td>
                                    <td>
                                        @if($billing->invoice)
                                            <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> {{ __('client.view') }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center text-muted">{{ __('client.no_service_payments') }}</div>
                @endif
            </div>
        </div>

        {{-- Project Payments --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong><i class="fas fa-project-diagram me-2"></i>{{ __('client.project_payment_history') }}</strong>
            </div>
            <div class="table-responsive">
                @php $allProjectBillings = $projects->flatMap(fn($p) => $p->billings->map(fn($b) => $b->setAttribute('project_name', $p->name))); @endphp
                @if($allProjectBillings->count() > 0)
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('client.project') }}</th>
                                <th>{{ __('client.amount_billed') }}</th>
                                <th>{{ __('client.amount_paid') }}</th>
                                <th>{{ __('client.payment_date') }}</th>
                                <th>{{ __('client.status') }}</th>
                                <th>{{ __('client.invoice') }}</th>
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
                                            {{ __('client.' . $billing->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($billing->invoice)
                                            <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> {{ __('client.view') }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center text-muted">{{ __('client.no_project_payments') }}</div>
                @endif
            </div>
        </div>
    @endif

    {{-- ================= MESSAGES TAB ================= --}}
    @if($tab === 'messages')
        <div class="row">
            {{-- Important Notes from Admin --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-bell me-2"></i>{{ __('client.important_notes_admin') }}</h6>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($importantNotes as $note)
                            <div class="border-start border-4 {{ $note->is_read ? 'border-secondary' : 'border-success' }} ps-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $note->subject }}</strong>
                                    @if(!$note->is_read)
                                        <span class="badge bg-success">{{ __('client.new') }}</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-1">{{ $note->message }}</p>
                                @if($note->document)
                                    <a href="{{ asset('storage/'.$note->document) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                        <i class="fas fa-paperclip"></i> {{ __('client.attachment') }}
                                    </a>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                    @if(!$note->is_read)
                                        <form action="{{ route('client.note.read', $note->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link">{{ __('client.mark_as_read') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">{{ __('client.no_notes_admin') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Submit Query --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-paper-plane me-2"></i>{{ __('client.submit_query') }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.query.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('client.subject') }} <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" required placeholder="{{ __('client.query_subject_placeholder') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('client.message') }} <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="3" required placeholder="{{ __('client.query_message_placeholder') }}"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ __('client.attachment_optional') }}</label>
                                <input type="file" name="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            </div>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-paper-plane me-2"></i>{{ __('client.submit_query_button') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- My Queries --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>{{ __('client.my_queries') }}</h6>
            </div>
            <div class="card-body">
                @forelse($myQueries as $query)
                    <div class="border rounded p-3 mb-3 {{ $query->status == 'pending' ? 'border-warning' : 'border-success' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $query->subject }}</h6>
                                <p class="text-muted mb-2">{{ $query->message }}</p>
                                @if($query->document)
                                    <a href="{{ asset('storage/'.$query->document) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                                        <i class="fas fa-paperclip"></i> {{ __('client.view') }} {{ __('client.attachment') }}
                                    </a>
                                @endif
                                @if($query->admin_reply)
                                    <div class="bg-light p-2 rounded">
                                        <small class="text-muted">{{ __('client.admin_reply') }}</small>
                                        <p class="mb-0">{{ $query->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                            <span class="badge bg-{{ $query->status == 'resolved' ? 'success' : 'warning' }} ms-2">
                                {{ __('client.' . $query->status) }}
                            </span>
                        </div>
                        <small class="text-muted">{{ __('client.submitted') }}: {{ $query->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                @empty
                    <p class="text-muted text-center">{{ __('client.no_queries_submitted') }}</p>
                @endforelse
            </div>
        </div>
    @endif

</div>
@endsection
