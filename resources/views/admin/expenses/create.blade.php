@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">
    {{-- PAGE HEADER --}}
    <x-page-header title="Add Expense" description="Record a new project expense with optional invoice attachment." />

    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- PROJECT ID (HIDDEN if coming from project) --}}
            @if(request('project_id'))
                <input type="hidden" name="project_id" value="{{ request('project_id') }}">
            @else
                <div class="mb-3">
                    <label for="project_id" class="form-label">Project (Optional)</label>
                    <select name="project_id" id="project_id" class="form-select">
                        <option value="">Select Project</option>
                        @foreach($projects ?? [] as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="amount" class="form-label">Amount <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control" required placeholder="0.00">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">Date <span style="color: red;">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description (Who, What, Why) <span style="color: red;">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="3" required placeholder="E.g., Labor cost - John Doe - Masonry work | Materials - Cement and bricks"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="labor">Labor</option>
                        <option value="material">Material</option>
                        <option value="transport">Transport</option>
                        <option value="equipment">Equipment</option>
                        <option value="utility">Utility</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="invoice" class="form-label">Invoice/Receipt (Optional)</label>
                    <input type="file" name="invoice" id="invoice" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx">
                    <small class="text-muted">Accepted: PDF, JPG, PNG, DOC, DOCX, XLSX</small>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save Expense
                </button>
                <a href="{{ request('project_id') ? route('admin.internalDetails.show', request('project_id')) . '?tab=expenses' : route('admin.expenses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection