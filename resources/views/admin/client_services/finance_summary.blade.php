@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== CLIENT INFO CARD ===== --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-primary shadow-sm p-3" style="background-color: #f0f7ff;">
                <h5 class="text-primary mb-2">{{ __('clients.client_details') }}</h5>
                <div class="row">
                    <div class="col-md-3"><strong>{{ __('clients.name') }}:</strong> {{ $client->name }}</div>
                    <div class="col-md-3"><strong>{{ __('clients.email') }}:</strong> {{ $client->email }}</div>
                    <div class="col-md-3"><strong>{{ __('clients.phone') }}:</strong> {{ $client->phone ?? '-' }}</div>
                    <div class="col-md-3"><strong>{{ __('clients.client_type') }}:</strong> {{ ucfirst($client->client_type ?? '-') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- HEADER FINANCE SUMMARY --}}
    <div class="client-header mb-4">
        <h3 class="text-dark">{{ __('client_services.finance_summary') }}</h3>
        <small class="text-muted">{{ $client->name }}</small>

        <div class="row mt-3 g-3">
            <div class="col-md-4">
                <div class="info-box text-center bg-secondary text-white p-3 rounded">
                    <small>{{ __('clients.total_service_amount') }}</small>
                    <div class="fs-5">{{ number_format($totalServiceAmount, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center bg-success text-white p-3 rounded">
                    <small>{{ __('clients.total_paid') }}</small>
                    <div class="fs-5">{{ number_format($totalPaid, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center bg-warning text-dark p-3 rounded">
                    <small>{{ __('clients.remaining_balance') }}</small>
                    <div class="fs-5">{{ number_format($totalRemaining, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MONTH FILTER FOR BILLINGS ===== --}}
    <div class="card mb-4" style="background: white;">
        <div class="card-body p-4">
            <form action="{{ request()->url() }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">📅 {{ __('client_services.filter_billings_by_month') }}</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">📆 {{ __('common.filter') }}</label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 120px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">&nbsp;</label>
                    <a href="{{ request()->url() }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> {{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ADD BILLING BUTTON --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.client-services.createClientBilling', $client->id) }}" class="btn btn-primary">
            + Add Billing
        </a>
        <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-outline-dark">
            ← Back
        </a>
    </div>

    {{-- BILLINGS TABLE --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            {{ __('client_services.all_billings') }}
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('client_services.amount_received') }}</th>
                        <th>{{ __('client_services.payment_date') }}</th>
                        <th>{{ __('client_services.status') }}</th>
                        <th>{{ __('client_services.invoice') }}</th>
                        <th>{{ __('client_services.notes') }}</th>
                        <th>{{ __('client_services.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allBillings as $i => $b)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ number_format($b['amount_paid'], 2) }}</td>
                            <td>{{ $b['payment_date'] ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $b['status']=='paid'?'bg-success':'bg-warning text-dark' }}">
                                    {{ ucfirst($b['status']) }}
                                </span>
                            </td>
                            <td>
                                @if($b['invoice'])
                                    <a href="{{ $b['invoice'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        View Invoice
                                    </a>
                                @endif
                            </td>
                            <td>{{ $b['notes'] }}</td>
                            <td>
                                <a href="{{ route('admin.client-services.editBilling', $b['id']) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.client-services.deleteBilling', $b['id']) }}" class="d-inline" onsubmit="return confirm('Delete this billing?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No billings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection