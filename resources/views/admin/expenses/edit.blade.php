@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">
    {{-- PAGE HEADER --}}
    <x-page-header title="Edit Expense" description="Update project expense details and attachments." />

    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('admin.expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- PROJECT ID (HIDDEN if exists) --}}
            @if($expense->project_id)
                <input type="hidden" name="project_id" value="{{ $expense->project_id }}">
            @else
                <div class="mb-3">
                    <label for="project_id" class="form-label">Project (Optional)</label>
                    <select name="project_id" id="project_id" class="form-select">
                        <option value="">Select Project</option>
                        @foreach($projects ?? [] as $proj)
                            <option value="{{ $proj->id }}" {{ $expense->project_id == $proj->id ? 'selected' : '' }}>
                                {{ $proj->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">Amount <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $expense->amount }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Date <span style="color: red;">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $expense->date }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description (Who, What, Why) <span style="color: red;">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ $expense->description }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="labor" {{ $expense->category === 'labor' ? 'selected' : '' }}>Labor</option>
                        <option value="material" {{ $expense->category === 'material' ? 'selected' : '' }}>Material</option>
                        <option value="transport" {{ $expense->category === 'transport' ? 'selected' : '' }}>Transport</option>
                        <option value="equipment" {{ $expense->category === 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="utility" {{ $expense->category === 'utility' ? 'selected' : '' }}>Utility</option>
                        <option value="other" {{ $expense->category === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="invoice" class="form-label">Invoice/Receipt (Optional)</label>
                    <input type="file" name="invoice" id="invoice" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
                    <small class="text-muted">Accepted: PDF, JPG, PNG, DOC, DOCX, XLSX</small>
                    @if($expense->invoice)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $expense->invoice) }}" target="_blank" class="btn btn-sm btn-secondary">
                                <i class="bi bi-download"></i> View Current Invoice
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Update Expense
                </button>
                <a href="{{ $expense->project_id ? route('admin.internalDetails.show', $expense->project_id) . '?tab=expenses' : route('admin.expenses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection