@extends('admin.layouts.app')

@section('content')
<div class="salary-container" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; padding: 30px 0;">
    
    {{-- PAGE HEADER --}}
    <div class="container-xl px-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">➕ Add Employee Expense</h1>
                <p class="text-muted mb-0" style="font-size: 14px;">Record a new expense for an employee (reimbursements, allowances, etc.)</p>
            </div>
            <a href="{{ route('admin.employee-expenses.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Expenses
            </a>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="container-xl px-4">
        <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.employee-expenses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="employee_id" class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                👤 Employee <span class="text-danger">*</span>
                            </label>
                            <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required
                                    style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                💰 Amount <span class="text-danger">*</span>
                            </label>
                            <input type="number" step="0.01" name="amount" id="amount" 
                                   class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount') }}" required placeholder="0.00"
                                   style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                📅 Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="date" id="date" 
                                   class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date', now()->format('Y-m-d')) }}" required
                                   style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="invoice" class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                                📎 Invoice/Receipt (Optional)
                            </label>
                            <input type="file" name="invoice" id="invoice" 
                                   class="form-control @error('invoice') is-invalid @enderror" 
                                   accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xlsx"
                                   style="padding: 10px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                            <small class="text-muted">Accepted: PDF, JPG, PNG, DOC, DOCX, XLSX (Max 5MB)</small>
                            @error('invoice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">
                            📝 Description/Notes <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" id="description" rows="3" 
                                  class="form-control @error('description') is-invalid @enderror" required
                                  placeholder="E.g., Travel reimbursement for client meeting, Medical allowance, etc."
                                  style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 10px; border: none; border-left: 4px solid #667eea;">
                        <i class="bi bi-info-circle text-primary"></i> 
                        <strong>Note:</strong> This expense will be added to the employee's salary calculation for the month.
                        <br>
                        <small class="text-muted">Formula: Basic Salary + (Daily Rate × Days Worked) + Overtime + <strong>Expenses</strong> - Advances = Net Salary</small>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                            <i class="bi bi-check-circle"></i> Save Expense
                        </button>
                        <a href="{{ route('admin.employee-expenses.index') }}" class="btn btn-outline-secondary" style="padding: 12px 24px; border-radius: 8px;">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea !important;
        background: white;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1) !important;
    }
</style>
@endsection
