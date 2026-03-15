@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">

    <h4>{{ __('projects.service_details') }}: {{ $service->service->name ?? '-' }}</h4>
    <p><strong>{{ __('projects.client') }}:</strong> {{ $service->client->name ?? '-' }}</p>
    <p><strong>{{ __('projects.service_type') }}:</strong> {{ ucfirst($service->service_type) ?? '-' }}</p>
    <p><strong>{{ __('projects.sub_type') }}:</strong> {{ $service->sub_type ?? '-' }}</p>
    <p><strong>{{ __('projects.rate_type') }}:</strong> {{ ucfirst($service->rate_type) ?? '-' }}</p>
    <p><strong>{{ __('projects.duration') }}:</strong> {{ $service->hours ?? $service->days ?? $service->months ?? '-' }}</p>
    <p><strong>{{ __('projects.rate') }}:</strong> 
        {{ $service->hours ? number_format($service->hourly_rate,2)
          : ($service->days ? number_format($service->daily_rate,2)
          : number_format($service->monthly_rate,2)) }}
    </p>

    @php $tab = request('tab', 'details'); @endphp
    <ul class="nav nav-tabs mt-4">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'details' ? 'active' : '' }}"
               href="{{ route('admin.client-services.view', $service->id) }}?tab=details">{{ __('projects.service_details') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'finance' ? 'active' : '' }}"
               href="{{ route('admin.client-services.view', $service->id) }}?tab=finance">{{ __('projects.finance_summary') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'internal' ? 'active' : '' }}"
               href="{{ route('admin.client-services.view', $service->id) }}?tab=internal">{{ __('projects.internal_ops') }}</a>
        </li>
    </ul>

    <div class="tab-content mt-3">

        @if($tab === 'details')
            <div class="tab-pane active">
                <h5>{{ __('projects.service_info') }}</h5>
                <p><strong>{{ __('projects.description') }}:</strong> {{ $service->description ?? '-' }}</p>
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
                <h5>{{ __('projects.internal_ops') }}</h5>
                <p><em>{{ __('projects.placeholder') }}</em></p>
            </div>
        @endif

    </div>

    <a href="{{ route('admin.clients.show', $service->client->id) }}" class="btn btn-sm btn-secondary mt-3">{{ __('projects.back_to_client') }}</a>

</div>
@endsection