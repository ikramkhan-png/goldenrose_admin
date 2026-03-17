@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.project_expenses') }}</h4>
            <p class="page-subtitle">{{ __('admin.project_expenses_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('admin.add_project_expense') }}
        </a>
    </div>

    <div class="info-box mb-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>{{ __('admin.note') }}:</strong>
        {{ __('admin.project_expenses_note') }}
        <a href="{{ route('admin.employee-expenses.index') }}" style="color: #4f46e5; font-weight: 600;">{{ __('admin.employee_expenses') }}</a>.
    </div>

    {{-- FILTERS --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.expenses.index') }}" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label">{{ __('admin.project') }}</label>
                    <input type="text" name="project_id" value="{{ request('project_id') }}"
                           class="form-control" placeholder="{{ __('admin.project_id_or_empty') }}">
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">{{ __('admin.month') }}</label>
                    <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                </div>
                <div class="d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>{{ __('admin.filter') }}
                    </button>
                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary">{{ __('admin.reset') }}</a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($expenses->count())
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('admin.project') }}</th>
                                <th>{{ __('admin.category') }}</th>
                                <th>{{ __('admin.amount') }}</th>
                                <th>{{ __('admin.date') }}</th>
                                <th>{{ __('admin.description') }}</th>
                                <th>{{ __('admin.invoice') }}</th>
                                <th class="td-center">{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                            <tr>
                                <td class="td-name">
                                    @if($expense->project)
                                        <a href="{{ route('admin.internalDetails.show', $expense->project->id) }}"
                                           style="color: #4f46e5; text-decoration: none;">
                                            {{ $expense->project->name }}
                                        </a>
                                    @else
                                        <span class="td-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                        {{ __('admin.category_' . $expense->category) }}
                                    </span>
                                </td>
                                <td class="td-warn">{{ number_format($expense->amount, 2) }}</td>
                                <td class="td-accent">{{ $expense->date }}</td>
                                <td class="td-muted">{{ $expense->description }}</td>
                                <td>
                                    @if($expense->invoice)
                                        <a href="{{ asset('storage/' . $expense->invoice) }}" target="_blank"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye me-1"></i>{{ __('admin.view') }}
                                        </a>
                                    @else
                                        <span class="td-muted">-</span>
                                    @endif
                                </td>
                                <td class="td-center">
                                    <a href="{{ route('admin.expenses.edit', $expense->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                    </a>
                                    <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                                            <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">{{ $expenses->links() }}</div>
    @else
        <div class="info-box">
            <i class="fas fa-info-circle me-2"></i>
            <strong>{{ __('admin.no_data_available') }}</strong>
        </div>
    @endif

</div>
@endsection
