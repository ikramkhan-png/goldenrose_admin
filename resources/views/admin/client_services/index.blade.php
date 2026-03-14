@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Client Services</h4>
        <a href="{{ route('admin.client-services.create') }}" class="btn btn-primary">+ Assign Service</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Service</th>
                <th>Rate Type</th>
                <th>Duration</th>
                <th>Rate</th>
                <th>Assigned Date</th>
                <th>total amount</th>
                <th width="160">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientServices as $service)
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
                    <td>{{ $service->client->name ?? '-' }}</td>
                    <td>{{ $service->service->name ?? '-' }}</td>
                    <td>{{ $rateType }}</td>
                    <td>{{ $duration }}</td>
                    <td>{{ $rate }}</td>
                    <td>{{ $service->assigned_date ?? '-' }}</td>
                    <td>
                        @if($service->hours > 0)
                            {{ number_format($service->hours * $service->hourly_rate, 2) }}
                        @elseif($service->days > 0)
                            {{ number_format($service->days * $service->daily_rate, 2) }}
                        @else
                            {{ number_format($service->months * $service->monthly_rate, 2) }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.client-services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.client-services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No services assigned yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection