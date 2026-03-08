@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== CLIENT INFO CARD ===== --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-primary shadow-sm p-3" style="background-color: #f0f7ff;">
                <h5 class="text-primary mb-2">Client Details</h5>
                <div class="row">
                    <div class="col-md-3"><strong>Name:</strong> {{ $client->name }}</div>
                    <div class="col-md-3"><strong>Email:</strong> {{ $client->email }}</div>
                    <div class="col-md-3"><strong>Phone:</strong> {{ $client->phone ?? '-' }}</div>
                    <div class="col-md-3"><strong>Client Type:</strong> {{ ucfirst($client->client_type ?? '-') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- HEADER FINANCE SUMMARY --}}
    <div class="client-header mb-4">
        <h3 class="text-dark">Finance Summary</h3>
        <small class="text-muted">{{ $client->name }}</small>

        <div class="row mt-3 g-3">
            <div class="col-md-4">
                <div class="info-box text-center bg-secondary text-white p-3 rounded">
                    <small>Total Service Amount</small>
                    <div class="fs-5">{{ number_format($totalServiceAmount, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center bg-success text-white p-3 rounded">
                    <small>Total Paid</small>
                    <div class="fs-5">{{ number_format($totalPaid, 2) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center bg-warning text-dark p-3 rounded">
                    <small>Remaining Balance</small>
                    <div class="fs-5">{{ number_format($totalRemaining, 2) }}</div>
                </div>
            </div>
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
            All Billings
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount Received</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th>Invoice</th>
                        <th>Notes</th>
                        <th>Actions</th>
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