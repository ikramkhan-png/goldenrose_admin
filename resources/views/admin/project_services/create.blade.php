@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">
    <x-page-header title="Add Service to Project" description="Assign machinery or manpower services to a specific project with hourly, daily, or monthly rates." />

    <div class="card border-0 shadow-sm p-4">
        <form action="{{ route('admin.project-services.store') }}" method="POST">
            @csrf

            {{-- Project Dropdown --}}
            <div class="mb-3">
                <label for="project_id" class="form-label">Project <span style="color: red;">*</span></label>
                <select name="project_id" id="project_id" class="form-select" required {{ $selectedProjectId ? 'disabled' : '' }}>
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $selectedProjectId == $project->id || old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @if($selectedProjectId)
                    <small class="text-muted">Selected from project details</small>
                    <input type="hidden" name="project_id" value="{{ $selectedProjectId }}">
                @endif
            </div>

            {{-- Service Type --}}
            <div class="mb-3">
                <label for="service_type" class="form-label">Service Type <span style="color: red;">*</span></label>
                <select name="service_type" id="service_type" class="form-select" required>
                    <option value="App\Models\Machinery" {{ old('service_type') == 'App\\Models\\Machinery' ? 'selected' : '' }}>Machinery</option>
                    <option value="App\Models\Manpower" {{ old('service_type') == 'App\\Models\\Manpower' ? 'selected' : '' }}>Manpower</option>
                </select>
            </div>

            {{-- Service Dropdown --}}
            <div class="mb-3">
                <label for="service_dropdown" class="form-label">Service <span style="color: red;">*</span></label>
                <select name="service_id" id="service_dropdown" class="form-select" required>
                    <option value="">Select Service</option>
                </select>
            </div>

            {{-- Rate Type --}}
            <div class="mb-3">
                <label for="rate_type" class="form-label">Rate Type <span style="color: red;">*</span></label>
                <select name="rate_type" id="rate_type" class="form-select" required>
                    <option value="hourly" {{ old('rate_type') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                    <option value="daily" {{ old('rate_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ old('rate_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
            </div>

            {{-- Duration --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="duration_input" class="form-label">Duration (<span id="duration_label">Hours</span>) <span style="color: red;">*</span></label>
                    <input type="number" name="duration" id="duration_input" class="form-control" min="1" required value="{{ old('duration') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="rate" class="form-label">Rate <span style="color: red;">*</span></label>
                    <input type="number" step="0.01" name="rate" id="rate" class="form-control" min="0" required value="{{ old('rate') }}">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Add Service
                </button>
                @if($selectedProjectId)
                    <a href="{{ route('admin.internalDetails.show', $selectedProjectId) . '?tab=services' }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                @else
                    <a href="{{ route('admin.project-services.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                @endif
            </div>
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
        const type = serviceTypeSelect.value.trim();
        serviceDropdown.innerHTML = '<option value="">Select Service</option>';

        let list = [];
        if(type === 'App\\Models\\Machinery' || type === 'App\Models\Machinery') {
            list = machineries;
        } else if(type === 'App\\Models\\Manpower' || type === 'App\Models\Manpower') {
            list = manpowers;
        }

        list.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            serviceDropdown.appendChild(option);
        });
    }

    function updateDurationLabel() {
        const rateType = rateTypeSelect.value;
        durationLabel.textContent = rateType === 'hourly' ? 'Hours' : rateType === 'daily' ? 'Days' : 'Months';
    }

    serviceTypeSelect.addEventListener('change', populateServices);
    rateTypeSelect.addEventListener('change', updateDurationLabel);
    window.addEventListener('DOMContentLoaded', () => {
        populateServices();
        updateDurationLabel();
    });
</script>
@endsection