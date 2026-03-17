@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('machinery.machinery_list') }}</h4>
            <p class="page-subtitle">{{ __('machinery.machinery_description') }}</p>
        </div>
        <a href="{{ route('admin.machinery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('machinery.add_machinery') }}
        </a>
    </div>

    {{-- MONTH FILTER --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.machinery.index') }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
                <div style="flex: 1; min-width: 220px;">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt me-1" style="color: #4f46e5;"></i>{{ __('admin.filter_by_month') }}
                    </label>
                    <input type="month" name="month" class="form-control"
                           value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 180px;">
                    <label class="form-label">
                        <i class="fas fa-filter me-1" style="color: #4f46e5;"></i>{{ __('admin.filter') }}
                    </label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 110px;">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.machinery.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times me-1"></i>{{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="p-3 mb-4" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-styled mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('machinery.name') }}</th>
                            <th>{{ __('machinery.model') }}</th>
                            <th>{{ __('machinery.number_plate') }}</th>
                            <th>{{ __('machinery.hourly_rate') }}</th>
                            <th>{{ __('machinery.daily_rate') }}</th>
                            <th>{{ __('machinery.monthly_rate') }}</th>
                            <th>{{ __('machinery.status') }}</th>
                            <th>{{ __('admin.created_date') }}</th>
                            <th class="td-center">{{ __('machinery.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($machineries as $machinery)
                            <tr>
                                <td class="td-muted">{{ $machinery->id }}</td>
                                <td class="td-name">{{ $machinery->name }}</td>
                                <td class="td-muted">{{ $machinery->model ?? '-' }}</td>
                                <td class="td-accent">{{ $machinery->number_plate ?? '-' }}</td>
                                <td>{{ number_format($machinery->hourly_rate, 2) }}</td>
                                <td>{{ number_format($machinery->daily_rate, 2) }}</td>
                                <td>{{ number_format($machinery->monthly_rate, 2) }}</td>
                                <td>
                                    @if ($machinery->status === 'active')
                                        <span class="badge" style="background: #dcfce7; color: #166534; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                            <i class="fas fa-circle me-1" style="font-size: 7px;"></i>{{ __('machinery.status_active') }}
                                        </span>
                                    @else
                                        <span class="badge" style="background: #f1f5f9; color: #64748b; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                            {{ __('machinery.status_inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="td-muted">{{ $machinery->created_at->format('Y-m-d') }}</td>
                                <td class="td-center">
                                    <a href="{{ route('admin.machinery.edit', $machinery->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i>{{ __('machinery.edit') }}
                                    </a>
                                    <form action="{{ route('admin.machinery.destroy', $machinery->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('{{ __('machinery.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash me-1"></i>{{ __('machinery.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 td-muted">
                                    <i class="fas fa-inbox" style="font-size: 28px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                    {{ __('machinery.no_machinery') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
