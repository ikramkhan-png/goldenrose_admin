@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Edit Billing for Project: {{ $billing->project->name }}</h4>

    <form action="{{ route('admin.project-billings.update', $billing->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="amount_billed" class="form-label">Amount Billed</label>
            <input type="number" step="0.01" name="amount_billed" id="amount_billed" 
                   class="form-control" value="{{ old('amount_billed', $billing->amount_billed) }}" required>
        </div>

        <div class="mb-3">
            <label for="amount_paid" class="form-label">Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" id="amount_paid" 
                   class="form-control" value="{{ old('amount_paid', $billing->amount_paid) }}">
        </div>

        <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" 
                   class="form-control" 
                   value="{{ old('payment_date', $billing->payment_date ? \Carbon\Carbon::parse($billing->payment_date)->format('Y-m-d') : '') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" {{ $billing->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $billing->status === 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="invoice" class="form-label">Invoice File</label>
            <input type="file" name="invoice" id="invoice" class="form-control">
            @if($billing->invoice)
                <p class="mt-1">Current File: <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank">View</a></p>
            @endif
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes', $billing->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Billing</button>
        <a href="{{ route('admin.projects.view', $billing->project->id) }}?tab=finance" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection