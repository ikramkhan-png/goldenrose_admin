@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">

    <h4>Service Details: {{ $service->service->name ?? '-' }}</h4>
    <p><strong>Client:</strong> {{ $service->client->name ?? '-' }}</p>
    <p><strong>Service Type:</strong> {{ ucfirst($service->service_type) ?? '-' }}</p>
    <p><strong>Sub Type:</strong> {{ $service->sub_type ?? '-' }}</p>
    <p><strong>Rate Type:</strong> {{ ucfirst($service->rate_type) ?? '-' }}</p>
    <p><strong>Duration:</strong> {{ $service->hours ?? $service->days ?? $service->months ?? '-' }}</p>
    <p><strong>Rate:</strong> 
        {{ $service->hours ? number_format($service->hourly_rate,2)
          : ($service->days ? number_format($service->daily_rate,2)
          : number_format($service->monthly_rate,2)) }}
    </p>

    @php $tab = request('tab', 'details'); @endphp
    <ul class="nav nav-tabs mt-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'details' ? 'active' : '' }}"
               href="{{ route('admin.client-services.view', $service->id) }}?tab=details">Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'finance' ? 'active' : '' }}"
               href="{{ route('admin.client-services.view', $service->id) }}?tab=finance">Finance</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'internal' ? 'active' : '' }}"
               href="{{ route('admin.client-services.view', $service->id) }}?tab=internal">Internal Ops</a>
        </li>
    </ul>

    <div class="tab-content mt-3">

        @if($tab === 'details')
            <div class="tab-pane active">
                <h5>Service Info</h5>
                <p><strong>Description:</strong> {{ $service->description ?? '-' }}</p>
            </div>
        @endif

        @if($tab === 'finance')
            <div class="tab-pane active">
                <h5>Finance</h5>
                <p class="text-muted">
                    Billing for services is handled from the Finance Summary page.
                </p>
            </div>
        @endif

        @if($tab === 'internal')
            <div class="tab-pane active">
                <h5>Internal Operations</h5>
                <p><em>Placeholder: assigned manpower/machinery, costs, usage, etc.</em></p>
            </div>
        @endif

    </div>

    <a href="{{ route('admin.clients.show', $service->client->id) }}"
       class="btn btn-sm btn-secondary mt-3">Back to Client</a>

</div>
@endsection