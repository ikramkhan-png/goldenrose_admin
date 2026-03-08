@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== HEADER ===== --}}
    <div class="client-header mb-4">
        <div>
            @if(isset($project))
                <h3 class="mb-1 fw-semibold text-white">Finance Summary - {{ $project->name }}</h3>
                <small class="text-white-50">Project Overview</small>
            @elseif(isset($client))
                <h3 class="mb-1 fw-semibold text-white">Finance Summary - {{ $client->name }}</h3>
                <small class="text-white-50">All Projects Overview</small>
            @endif
        </div>

        <div class="row mt-3 g-3">
            @if(isset($project))
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Project Budget</small>
                    <div class="fs-5">{{ number_format($budget ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Additional Billings</small>
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
                    <small>Remaining Balance</small>
                    <div class="fs-5 {{ ($totalRemaining ?? 0) > 0 ? 'text-warning' : 'text-success' }}">
                        {{ number_format($totalRemaining ?? 0, 2) }}
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-4">
                <div class="info-box text-center">
                    <small>Total Contract Value</small>
                    <div class="fs-5">{{ number_format($totalBilled ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center">
                    <small>Total Paid</small>
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

    {{-- ===== BILLINGS TABLE ===== --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold mb-3">Billing Details</h5>
         @if(isset($project))
            <a href="{{ route('admin.projects.view', $project->id) }}" class="btn btn-outline-dark mt-3">
                ← Back to Project
            </a>
        @elseif(isset($client))
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=projects" class="btn btn-outline-dark mt-3">
                ← Back to Client Projects
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
                            <th>Billed</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                            <th>Notes</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($projectsBillings as $index => $b)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            @if(isset($client))
                                <td>{{ $b['project_name'] ?? '-' }}</td>
                            @endif
                            <td>{{ number_format($b['amount_billed'], 2) }}</td>
                            <td>{{ number_format($b['amount_paid'] ?? 0, 2) }}</td>
                            <td>
                                <span class="{{ ($b['remaining'] ?? 0) > 0 ? 'text-warning' : 'text-success' }}">
                                    {{ number_format($b['remaining'] ?? 0, 2) }}
                                </span>
                            </td>
                            <td>
                                @if(($b['status'] ?? '') === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-success">Paid</span>
                                @endif
                            </td>
                            <td>{{ $b['payment_date'] ?? '-' }}</td>
                            <td>{{ $b['notes'] ?? '-' }}</td>
                            <td>
                                @if(!empty($b['invoice']))
                                    <a href="{{ asset('storage/'.$b['invoice']) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
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
        <p class="text-muted text-center">No billing records found.</p>
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