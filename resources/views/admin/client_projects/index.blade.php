@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('clients.client_projects') }}</h4>
            <p class="page-subtitle">{{ __('clients.client_projects_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.client-projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('clients.assign_project') }}
        </a>
    </div>

    {{-- MONTH FILTER --}}
    <div class="card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.client-projects.index') }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
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
                    <a href="{{ route('admin.client-projects.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times me-1"></i>{{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
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
                            <th>{{ __('clients.client') }}</th>
                            <th>{{ __('clients.project_name') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th>{{ __('admin.start_date') }}</th>
                            <th>{{ __('admin.end_date') }}</th>
                            <th class="td-center">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td class="td-muted">{{ $loop->iteration }}</td>
                                <td class="td-name">{{ $project->client->name ?? '-' }}</td>
                                <td class="td-accent">{{ $project->name }}</td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                    </span>
                                </td>
                                <td class="td-muted">{{ $project->start_date ?? '-' }}</td>
                                <td class="td-muted">{{ $project->end_date ?? '-' }}</td>
                                <td class="td-center">
                                    <a href="{{ route('admin.client-projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                    </a>
                                    <form action="{{ route('admin.client-projects.destroy', $project) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 td-muted">
                                    <i class="fas fa-inbox" style="font-size: 28px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                    {{ __('clients.no_projects') }}
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
