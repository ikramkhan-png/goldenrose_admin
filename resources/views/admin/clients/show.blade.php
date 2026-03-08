@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ===== INTRO TEXT ===== --}}
    <div class="card mb-4 p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
        <h5 class="mb-2">Client Dashboard</h5>
        <p class="mb-0" style="opacity: 0.9;">Manage client details, assigned services and projects. Use the tabs below to switch views.</p>
    </div>

    {{-- ===== CLIENT HEADER ===== --}}
    <div class="card mb-4 p-3">
        <h4>Client Details: {{ $client->name }}</h4>
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Phone:</strong> {{ $client->phone ?? '-' }}</p>
        <p><strong>Client Type:</strong> {{ ucfirst($client->client_type) }}</p>
    </div>

    {{-- ===== TOP TABS ===== --}}
    @php $tab = request('tab', 'services'); @endphp
    <div class="mb-3">
        <a href="{{ route('admin.clients.show', $client->id) }}?tab=services"
           class="btn btn-sm {{ $tab === 'services' ? 'btn-primary' : 'btn-outline-primary' }}">
            Assigned Services
        </a>
        <a href="{{ route('admin.clients.show', $client->id) }}?tab=projects"
           class="btn btn-sm {{ $tab === 'projects' ? 'btn-primary' : 'btn-outline-primary' }}">
            Assigned Projects
        </a>
    </div>

    {{-- ================= SERVICES TAB ================= --}}
    @if($tab === 'services')
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5>Services</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.client-services.create') }}?client_id={{ $client->id }}"
                   class="btn btn-sm btn-success">+ Assign Service</a>
                <a href="{{ route('admin.client-services.financeSummary', $client->id) }}"
                   class="btn btn-sm btn-outline-dark">Finance Summary</a>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Rate Type</th>
                    <th>Duration</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($client->services as $service)
                @php
                    // Determine rate type and duration
                    if($service->hours > 0) {
                        $rateType = 'Hourly';
                        $duration  = $service->hours;
                        $rate      = number_format($service->hourly_rate, 2);
                    } elseif($service->days > 0) {
                        $rateType = 'Daily';
                        $duration  = $service->days;
                        $rate      = number_format($service->daily_rate, 2);
                    } else {
                        $rateType = 'Monthly';
                        $duration  = $service->months;
                        $rate      = number_format($service->monthly_rate, 2);
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $service->service->name ?? '-' }}</td>
                    <td>{{ $rateType }}</td>
                    <td>{{ $duration }}</td>
                    <td>{{ $rate }}</td>
                    <td>
                        @if($service->hours > 0)
                            {{ number_format($service->hours * $service->hourly_rate, 2) }}
                        @elseif($service->days > 0)
                            {{ number_format($service->days * $service->daily_rate, 2) }}
                        @else
                            {{ number_format($service->months * $service->monthly_rate, 2) }}
                        @endif
                    </td>
                    <td class="d-flex gap-1 flex-wrap align-items-center actions-cell" style="min-width: 140px;">
                        <a href="{{ route('admin.client-services.view', $service->id) }}"
                           class="btn btn-sm btn-info px-2">View</a>
                        <a href="{{ route('admin.client-services.edit', $service->id) }}"
                           class="btn btn-sm btn-warning px-2">Edit</a>
                        <form action="{{ route('admin.client-services.destroy', $service->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger px-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No services assigned yet
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= PROJECTS TAB ================= --}}
    @if($tab === 'projects')
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5>Projects</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.projects.create') }}?client_id={{ $client->id }}"
                   class="btn btn-sm btn-success">+ Assign Project</a>
                <a href="{{ route('admin.clients.projectsFinanceSummary', $client->id) }}"
                   class="btn btn-sm btn-outline-dark">Finance Summary</a>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Budget</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($client->projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ ucfirst($project->type) }}</td>
                    <td>{{ number_format($project->budget ?? 0, 2) }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date ?? '-' }}</td>
                    <td class="d-flex gap-1 flex-wrap align-items-center actions-cell" style="min-width: 140px;">
                        <a href="{{ route('admin.projects.internalShowFromClient', $project->id) }}"
                           class="btn btn-sm btn-info px-2">View</a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}"
                           class="btn btn-sm btn-warning px-2">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger px-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No projects assigned yet
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

</div>
@endsection