@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Assign Service to Client</h4>

    <form action="{{ route('admin.client-services.store') }}" method="POST">
        @csrf

        {{-- Client --}}
        <div class="mb-3">
            <label class="form-label">Client</label>
            <select name="client_id" class="form-control" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Service Type --}}
        <div class="mb-3">
            <label class="form-label">Service Type</label>
            <select name="service_type" class="form-control" id="service_type" required>
                <option value="App\Models\Machinery">Machinery</option>
                <option value="App\Models\Manpower">Manpower</option>
            </select>
        </div>

        {{-- Service --}}
        <div class="mb-3">
            <label class="form-label">Service</label>
            <select name="service_id" class="form-control" id="service_dropdown" required></select>
        </div>

        {{-- Rate Type --}}
        <div class="mb-3">
            <label class="form-label">Rate Type</label>
            <select name="rate_type" class="form-control" id="rate_type" required>
                <option value="hourly">Hourly</option>
                <option value="daily">Daily</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        {{-- Duration --}}
        <div class="mb-3">
            <label class="form-label">Duration (<span id="duration_label">Hours</span>)</label>
            <input type="number" name="duration" class="form-control" min="1" required>
        </div>

        {{-- Rate --}}
        <div class="mb-3">
            <label class="form-label">Rate</label>
            <input type="number" name="rate" step="0.01" class="form-control" min="0" required>
        </div>

        <button class="btn btn-success">Assign Service</button>
        <a href="{{ route('admin.client-services.index') }}" class="btn btn-secondary">Cancel</a>
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