@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Add Billing for Client: {{ $client->name }}</h4>

    <form action="{{ route('admin.client-services.storeClientBilling', $client->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Amount Received</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Payment Date</label>
            <input type="date" name="payment_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Invoice (PDF/JPG/PNG)</label>
            <input type="file" name="invoice" class="form-control">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-primary">Save Billing</button>
        <a href="{{ route('admin.client-services.financeSummary', $client->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection