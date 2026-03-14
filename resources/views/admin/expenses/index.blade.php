@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>📦 {{ __('admin.project_expenses') }}</h2>
            <small class="text-muted">{{ __('admin.project_expenses_subtitle') }}</small>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-success">{{ __('admin.add_project_expense') }}</a>
    </div>

    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle"></i>
        <strong>{{ __('admin.note') }}:</strong>
        {{ __('admin.project_expenses_note') }}
        <a href="{{ route('admin.employee-expenses.index') }}" class="alert-link">{{ __('admin.employee_expenses') }}</a>.
    </div>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.expenses.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('admin.project') }}</label>
            <input type="text" name="project_id" value="{{ request('project_id') }}" class="form-control" placeholder="{{ __('admin.project_id_or_empty') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ __('admin.month') }}</label>
            <input type="month" name="month" value="{{ request('month') }}" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">{{ __('admin.filter') }}</button>
            <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($expenses->count())
    <div class="card border-0" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0" style="font-size: 13px;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.project') }}</th>
                            <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.category') }}</th>
                            <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.amount') }}</th>
                            <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.date') }}</th>
                            <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.description') }}</th>
                            <th style="padding: 18px 16px; font-weight: 600; border: none;">{{ __('admin.invoice') }}</th>
                            <th style="padding: 18px 16px; font-weight: 600; border: none; text-align: center;">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr style="border-bottom: 1px solid #f0f2f7; transition: all 0.2s; background: white;">
                            <td style="padding: 16px; color: #2c3e50; font-weight: 600;">
                                @if($expense->project)
                                    <a href="{{ route('admin.internalDetails.show', $expense->project->id) }}" class="text-decoration-none">
                                        {{ $expense->project->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <span class="badge bg-secondary">
                                    {{ __('admin.category_' . $expense->category) }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: #f39c12; font-weight: 600;">{{ number_format($expense->amount, 2) }}</td>
                            <td style="padding: 16px; color: #667eea;">{{ $expense->date }}</td>
                            <td style="padding: 16px; color: #555;">{{ $expense->description }}</td>
                            <td style="padding: 16px;">
                                @if($expense->invoice)
                                    <a href="{{ asset('storage/' . $expense->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> {{ __('admin.view') }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning" style="padding: 6px 12px; border-radius: 6px;">
                                        <i class="bi bi-pencil"></i> {{ __('admin.edit') }}
                                    </a>
                                    <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 6px 12px; border-radius: 6px;" onclick="return confirm('{{ __('admin.confirm_delete') }}');">
                                            <i class="bi bi-trash"></i> {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $expenses->links() }}
    @else
        <div class="alert border-0" style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 12px; padding: 20px; color: #667eea; border-left: 4px solid #667eea;">
            <i class="bi bi-info-circle"></i> <strong>{{ __('admin.no_data_available') }}</strong>
        </div>
    @endif
</div>
@endsection