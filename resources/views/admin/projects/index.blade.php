@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="d-flex justify-content-between mb-3">
        <h4>Projects</h4>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">+ Add Project</a>
    </div>

    {{-- FILTER CARD --}}
    <div class="card mb-4" style="background: white;">
        <div class="card-body p-4">
            <form action="{{ route('admin.projects.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">📅 {{ __('Filter by month') }}</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">📆 {{ __('Filter') }}</label>
                    <div class="filter-display">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 120px;">
                    <label class="form-label fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">&nbsp;</label>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> {{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 mb-3" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-styled mb-0">
                    <thead>
                        <tr>
                            <th class="td-muted">#</th>
                            <th>Project Name</th>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Budget</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="td-center" width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td class="td-muted">{{ $loop->iteration }}</td>
                                <td class="td-name">{{ $project->name }}</td>
                                <td>{{ $project->client?->name ?? '-' }}</td>
                                <td>{{ ucfirst($project->type) }}</td>
                                <td>{{ $project->budget ? number_format($project->budget, 2) : '-' }}</td>
                                <td>{{ $project->start_date }}</td>
                                <td>{{ $project->end_date ?? '-' }}</td>
                                <td class="td-center">
                                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No projects found for {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection