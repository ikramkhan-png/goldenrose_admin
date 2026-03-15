@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>{{ __('client_services.assign_service_to_client') }}</h4>

    <form action="{{ route('admin.client-services.store') }}" method="POST">
        @csrf

        {{-- Client --}}
        <div class="mb-3">
            <label class="form-label">{{ __('clients.client') }} <span class="text-danger">*</span></label>
            <select name="client_id" class="form-control" required {{ request('client_id') ? 'readonly style="background-color: #e9ecef; pointer-events: none;"' : '' }}>
                <option value="">{{ __('client_services.select_client') }}</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->email }})
                    </option>
                @endforeach
            </select>
            @if(request('client_id'))
                <small class="text-muted">{{ __('client_services.auto_selected_from_client_page') }}</small>
            @endif
        </div>

        {{-- Service Type --}}
        <div class="mb-3">
            <label class="form-label">{{ __('client_services.service_type') }}</label>
            <select name="service_type" class="form-control" id="service_type" required>
                <option value="App\Models\Machinery">{{ __('machinery.machinery') }}</option>
                <option value="App\Models\Manpower">{{ __('manpower.manpower') }}</option>
            </select>
        </div>

        {{-- Service --}}
        <div class="mb-3">
            <label class="form-label">{{ __('client_services.service') }}</label>
            <select name="service_id" class="form-control" id="service_dropdown" required></select>
        </div>

        {{-- Rate Type --}}
        <div class="mb-3">
            <label class="form-label">{{ __('client_services.rate_type') }}</label>
            <select name="rate_type" class="form-control" id="rate_type" required>
                <option value="hourly">{{ __('client_services.hourly') }}</option>
                <option value="daily">{{ __('client_services.daily') }}</option>
                <option value="monthly">{{ __('client_services.monthly') }}</option>
            </select>
        </div>

        {{-- Duration --}}
        <div class="mb-3">
            <label class="form-label">{{ __('client_services.duration') }} (<span id="duration_label">{{ __('client_services.hours') }}</span>)</label>
            <input type="number" name="duration" class="form-control" min="1" required>
        </div>

        {{-- Rate --}}
        <div class="mb-3">
            <label class="form-label">{{ __('client_services.rate') }}</label>
            <input type="number" name="rate" step="0.01" class="form-control" min="0" required>
        </div>

        {{-- Assigned Date --}}
        <div class="mb-3">
            <label class="form-label">{{ __('client_services.assigned_date') }} <span class="text-danger">*</span></label>
            <input type="date" name="assigned_date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
            <small class="text-muted">{{ __('client_services.date_used_for_monthly_filtering') }}</small>
        </div>

        <button class="btn btn-success">{{ __('client_services.assign_service') }}</button>
        <a href="{{ route('admin.client-services.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
    </form>
</div>

<script>
const machineries = @json($machineries);
const manpowers = @json($manpowers);

const serviceTypeSelect = document.getElementById('service_type');
const serviceDropdown = document.getElementById('service_dropdown');
const rateTypeSelect = document.getElementById('rate_type');
const durationLabel = document.getElementById('duration_label');

function populateServices() {
    const list = serviceTypeSelect.value.includes('Machinery') ? machineries : manpowers;
    serviceDropdown.innerHTML = '';
    list.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        serviceDropdown.appendChild(option);
    });
}

function updateDurationLabel() {
    durationLabel.textContent =
        rateTypeSelect.value === 'hourly' ? '{{ __('client_services.hours') }}' :
        rateTypeSelect.value === 'daily'  ? '{{ __('client_services.days') }}'  : '{{ __('client_services.months') }}';
}

serviceTypeSelect.addEventListener('change', populateServices);
rateTypeSelect.addEventListener('change', updateDurationLabel);
document.addEventListener('DOMContentLoaded', () => {
    populateServices();
    updateDurationLabel();
});
</script>
@endsection