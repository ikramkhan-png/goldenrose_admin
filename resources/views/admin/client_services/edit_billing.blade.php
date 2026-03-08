@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Edit Billing</h4>

    <form action="{{ route('admin.client-services.updateBilling', $billing->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Amount Received</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" 
                value="{{ old('amount_paid', $billing->amount_paid) }}" required>
        </div>

        <div class="mb-3">
            <label>Payment Date</label>
            <input type="date" name="payment_date" class="form-control" 
                value="{{ old('payment_date', optional($billing->payment_date)->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ old('status', $billing->status)=='pending'?'selected':'' }}>Pending</option>
                <option value="paid" {{ old('status', $billing->status)=='paid'?'selected':'' }}>Paid</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Invoice (PDF/JPG/PNG)</label>
            <input type="file" name="invoice" class="form-control">
            @if($billing->invoice)
                <small>Current: <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank">View Invoice</a></small>
            @endif
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $billing->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Billing</button>
        <a href="{{ route('admin.client-services.financeSummary', $billing->clientService->client_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection