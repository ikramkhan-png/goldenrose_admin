@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== HEADER ===== --}}
    <div class="client-header mb-4">
        <div>
            @if(isset($project))
                <h3 class="mb-1 fw-semibold text-white">{{ __('projects.finance_summary') }} - {{ $project->name }}</h3>
                <small class="text-white-50">{{ __('projects.project_overview') }}</small>
            @elseif(isset($client))
                <h3 class="mb-1 fw-semibold text-white">{{ __('projects.finance_summary') }} - {{ $client->name }}</h3>
                <small class="text-white-50">{{ __('projects.all_projects_overview') }}</small>
            @endif
        </div>

        <div class="row mt-3 g-3">
            @if(isset($project))
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('projects.project_budget') }}</small>
                    <div class="fs-5">{{ number_format($budget ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('projects.additional_billings') }}</small>
                    <div class="fs-5">{{ number_format($additionalBilled ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Total Contract Value</small>
                    <div class="fs-5 text-info">{{ number_format($totalBilled ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('projects.remaining_balance') }}</small>
                    <div class="fs-5 {{ ($totalRemaining ?? 0) > 0 ? 'text-warning' : 'text-success' }}">
                        {{ number_format($totalRemaining ?? 0, 2) }}
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-4">
                <div class="info-box text-center">
                    <small>{{ __('projects.total_contract_value_all') }}</small>
                    <div class="fs-5">{{ number_format($totalBilled ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center">
                    <small>{{ __('projects.total_paid') }}</small>
                    <div class="fs-5">{{ number_format($totalPaid ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center">
                    <small>Remaining Balance</small>
                    <div class="fs-5 {{ ($totalRemaining ?? 0) > 0 ? 'text-warning' : 'text-success' }}">
                        {{ number_format($totalRemaining ?? 0, 2) }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== MONTH FILTER FOR BILLINGS ===== --}}
    <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-4">
            <form action="{{ request()->url() }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('projects.filter_billings_by_month') }}</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('projects.filter') }}</label>
                    <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('projects.all_data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 120px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">&nbsp;</label>
                    <a href="{{ request()->url() }}" class="btn btn-outline-secondary w-100" style="padding: 12px 14px; border: 2px solid #6c757d; border-radius: 8px; font-weight: 500; font-size: 14px;">
                        <i class="fas fa-times"></i> {{ __('projects.show_all') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ===== BILLINGS TABLE ===== --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold mb-3">{{ __('projects.billing_details') }}</h5>
         @if(isset($project))
            <a href="{{ route('admin.projects.view', $project->id) }}" class="btn btn-outline-dark mt-3">
                {{ __('projects.back_to_project') }}
            </a>
        @elseif(isset($client))
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=projects" class="btn btn-outline-dark mt-3">
                {{ __('projects.back_to_client_projects') }}
            </a>
        @endif
    </div>
    
    @if(isset($projectsBillings) && count($projectsBillings) > 0)
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            @if(isset($client))
                                <th>Project</th>
                            @endif
                            <th>{{ __('projects.billed') }}</th>
                            <th>{{ __('projects.paid') }}</th>
                            <th>{{ __('projects.remaining') }}</th>
                            <th>{{ __('projects.status') }}</th>
                            <th>{{ __('projects.payment_date') }}</th>
                            <th>{{ __('projects.notes') }}</th>
                            <th>{{ __('projects.invoice') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($projectsBillings as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if(isset($client))
                                <td>{{ $b['project_name'] }}</td>
                            @endif
                            <td style="text-align: right; font-weight: 600;">{{ number_format($b['amount_billed'], 2) }}</td>
                            <td style="text-align: right; color: #28a745;">{{ number_format($b['amount_paid'], 2) }}</td>
                            <td style="text-align: right; color: #dc3545;">{{ number_format($b['amount_billed'] - $b['amount_paid'], 2) }}</td>
                            <td>
                                @if($b['status'] == 'paid')
                                    <span class="badge bg-success">{{ __('projects.paid') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ __('common.pending') }}</span>
                                @endif
                            </td>
                            <td>{{ $b['payment_date'] ? \Carbon\Carbon::parse($b['payment_date'])->format('M d, Y') : '-' }}</td>
                            <td>{{ $b['notes'] ?? '-' }}</td>
                            <td>
                                @if(!empty($b['invoice']))
                                    <a href="{{ asset('storage/' . $b['invoice']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-file-earmark-pdf"></i> {{ __('projects.view') }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="text-muted text-center">{{ __('projects.no_billing_records') }} {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('projects.all_data') }}.</p>
    @endif

    
</div>

{{-- ===== STYLE BLOCK ===== --}}
<style>
.client-header{
    background: linear-gradient(135deg, #1f2937, #374151);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.info-box{
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
    padding: 14px;
    color: #fff;
}
.info-box small{
    font-size: 12px;
    opacity: 0.7;
}
.info-box div{
    font-weight: 600;
}
</style>
@endsection