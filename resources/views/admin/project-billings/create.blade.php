@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">
    <x-page-header title="Add Billing" description="if no new billing amount is generated for this project write zero(0) in amount billed field" />
 <div class="card border-0 shadow-sm p-4">
    <h4>Add Billing for Project: {{ $project->name }}</h4>

    <form action="{{ route('admin.project-billings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="mb-3">
            <label class="form-label">Amount Billed</label>
            <input type="number" step="0.01" name="amount_billed" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount Paid</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" selected>Pending</option>
                <option value="paid">Paid</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Date</label>
            <input type="date" name="payment_date" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Invoice (optional)</label>
            <input type="file" name="invoice" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-success">Add Billing</button>
        <a href="{{ route('admin.projects.view', $project->id.'?tab=finance') }}" class="btn btn-secondary">Cancel</a>
    </form>
 </div>
</div>
@endsection