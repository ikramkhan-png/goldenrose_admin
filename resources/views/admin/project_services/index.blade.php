@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Project Services</h2>
    
    {{-- MONTH FILTER --}}
    <div class="card mb-4" style="background: white;">
        <div class="card-body p-4">
            <form action="{{ route('admin.project-services.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
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
                    <a href="{{ route('admin.project-services.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> {{ __('Show All') }}
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <a href="{{ route('admin.project-services.create') }}" class="btn btn-primary mb-3">Add Service</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-styled">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Service Type</th>
                <th>Service</th>
                <th>Rate Type</th>
                <th>Duration</th>
                <th>Rate</th>
                <th>Total Cost</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projectServices as $ps)
            <tr>
                <td>{{ $ps->id }}</td>
                <td>{{ $ps->project->name }}</td>
                <td>{{ class_basename($ps->service_type) }}</td>
                <td>{{ $ps->service->name ?? '-' }}</td>
                <td>
                    @if($ps->hours) Hourly
                    @elseif($ps->days) Daily
                    @elseif($ps->months) Monthly
                    @endif
                </td>
                <td>
                    {{ $ps->hours ?? $ps->days ?? $ps->months }}
                </td>
                <td>
                    {{ $ps->hourly_rate ?? $ps->daily_rate ?? $ps->monthly_rate }}
                </td>
                <td>{{ $ps->total_cost }}</td>
                <td>{{ $ps->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('admin.project-services.edit', $ps->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.project-services.destroy', $ps->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection