@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="d-flex justify-content-between mb-3">
        <h4>Projects</h4>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">+ Add Project</a>
    </div>

    {{-- FILTER CARD --}}
    <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-4">
            <form action="{{ route('admin.projects.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 Select Month</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 Period</label>
                    <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                        {{ $selectedMonth->format('F Y') }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Client</th>
                <th>Type</th>
                <th>Budget</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th width="160">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client?->name ?? '-' }}</td>
                    <td>{{ ucfirst($project->type) }}</td>
                    <td>{{ $project->budget ? number_format($project->budget, 2) : '-' }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No projects found for {{ $selectedMonth->format('F Y') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection