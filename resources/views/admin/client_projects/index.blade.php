@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Client Projects</h4>
        <a href="{{ route('admin.client-projects.create') }}" class="btn btn-primary">+ Assign Project</a>
    </div>

    {{-- MONTH FILTER --}}
    <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-4">
            <form action="{{ route('admin.client-projects.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 Filter by Month</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 Filter</label>
                    <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                    </div>
                </div>
                @if(request('month'))
                <div style="min-width: 120px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">&nbsp;</label>
                    <a href="{{ route('admin.client-projects.index') }}" class="btn btn-outline-secondary w-100" style="padding: 12px 14px; border: 2px solid #6c757d; border-radius: 8px; font-weight: 500; font-size: 14px;">
                        <i class="fas fa-times"></i> {{ __('Show All') }}
                    </a>
                </div>
                @endif
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
                <th>Client</th>
                <th>Project Name</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th width="140">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->client->name ?? '-' }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$project->status)) }}</td>
                    <td>{{ $project->start_date ?? '-' }}</td>
                    <td>{{ $project->end_date ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.client-projects.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.client-projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No projects assigned yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection