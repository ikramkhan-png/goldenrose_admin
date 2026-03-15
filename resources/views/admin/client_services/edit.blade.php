@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Edit Client Service</h4>

    <form action="{{ route('admin.client-services.update', $clientService) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Client --}}
        <div class="mb-3">
            <label class="form-label">Client</label>
            <input type="text" class="form-control" value="{{ $clientService->client->name }}" disabled>
        </div>

        {{-- Service Type --}}
        <div class="mb-3">
            <label class="form-label">Service Type</label>
            <select name="service_type" class="form-control" id="service_type" required>
                <option value="App\Models\Machinery" @selected($clientService->service_type === 'App\Models\Machinery')>Machinery</option>
                <option value="App\Models\Manpower" @selected($clientService->service_type === 'App\Models\Manpower')>Manpower</option>
            </select>
        </div>

        {{-- Service --}}
        <div class="mb-3">
            <label class="form-label">Service</label>
            <select name="service_id" class="form-control" id="service_dropdown" required>
                <option value="{{ $clientService->service_id }}">{{ $clientService->service->name ?? 'Select Service' }}</option>
            </select>
        </div>

        {{-- Rate Type --}}
        <div class="mb-3">
            <label class="form-label">Rate Type</label>
            <select name="rate_type" class="form-control" id="rate_type" required>
                <option value="hourly"  @selected($clientService->hours > 0)>Hourly</option>
                <option value="daily"   @selected($clientService->days > 0)>Daily</option>
                <option value="monthly" @selected($clientService->months > 0)>Monthly</option>
            </select>
        </div>

        {{-- Duration --}}
        <div class="mb-3">
            <label class="form-label">Duration (<span id="duration_label">Hours</span>)</label>
            <input type="number" name="duration" class="form-control"
                   value="{{ $clientService->hours > 0 ? $clientService->hours : ($clientService->days > 0 ? $clientService->days : $clientService->months) }}" min="1" required>
        </div>

        {{-- Rate --}}
        <div class="mb-3">
            <label class="form-label">Rate</label>
            <input type="number" step="0.01" name="rate"
                   value="{{ $clientService->hours > 0 ? $clientService->hourly_rate : ($clientService->days > 0 ? $clientService->daily_rate : $clientService->monthly_rate) }}"
                   class="form-control" min="0" required>
        </div>

        {{-- Assigned Date --}}
        <div class="mb-3">
            <label class="form-label">Assigned Date <span class="text-danger">*</span></label>
            <input type="date" name="assigned_date" class="form-control" required 
                   value="{{ $clientService->assigned_date ? $clientService->assigned_date->format('Y-m-d') : now()->format('Y-m-d') }}">
            <small class="text-muted">This date will be used for monthly filtering</small>
        </div>

        {{-- Buttons --}}
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.client-services.index') }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
    </form>
</div>

<script>
const machineries = @json($machineries ?? []);
const manpowers = @json($manpowers ?? []);

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
        rateTypeSelect.value === 'hourly' ? 'Hours' :
        rateTypeSelect.value === 'daily'  ? 'Days'  : 'Months';
}

serviceTypeSelect.addEventListener('change', populateServices);
rateTypeSelect.addEventListener('change', updateDurationLabel);
document.addEventListener('DOMContentLoaded', () => {
    populateServices();
    updateDurationLabel();
});
</script>
@endsection