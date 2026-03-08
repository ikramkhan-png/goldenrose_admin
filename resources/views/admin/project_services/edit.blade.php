@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Project Service</h2>

    <form action="{{ route('admin.project-services.update', $projectService->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Project Dropdown --}}
        <div class="mb-3">
            <label>Project</label>
            <select name="project_id" class="form-control" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $projectService->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Service Type --}}
        <div class="mb-3">
            <label>Service Type</label>
            <select name="service_type" class="form-control" id="service_type" required>
                <option value="App\Models\Machinery" {{ $projectService->service_type === 'App\Models\Machinery' ? 'selected' : '' }}>Machinery</option>
                <option value="App\Models\Manpower" {{ $projectService->service_type === 'App\Models\Manpower' ? 'selected' : '' }}>Manpower</option>
            </select>
        </div>

        {{-- Service Dropdown --}}
        <div class="mb-3">
            <label>Service</label>
            <select name="service_id" class="form-control" id="service_dropdown" required></select>
        </div>

        {{-- Rate Type --}}
        <div class="mb-3">
            <label>Rate Type</label>
            <select name="rate_type" class="form-control" id="rate_type" required>
                <option value="hourly" {{ $projectService->hours ? 'selected' : '' }}>Hourly</option>
                <option value="daily" {{ $projectService->days ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ $projectService->months ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>

        {{-- Duration --}}
        <div class="mb-3">
            <label>Duration (<span id="duration_label">Hours</span>)</label>
            <input type="number" name="duration" class="form-control" id="duration_input" min="1" required>
        </div>

        {{-- Rate --}}
        <div class="mb-3">
            <label>Rate</label>
            <input type="number" step="0.01" name="rate" class="form-control" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Update Service</button>
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
        serviceDropdown.innerHTML = '';

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
            if(item.id == "{{ $projectService->service_id }}") option.selected = true;
            serviceDropdown.appendChild(option);
        });
    }

    function updateDurationLabel() {
        const rateType = rateTypeSelect.value;
        durationLabel.textContent = rateType === 'hourly' ? 'Hours' : rateType === 'daily' ? 'Days' : 'Months';

        // Pre-fill duration input
        const durationInput = document.getElementById('duration_input');
        if(rateType === 'hourly') durationInput.value = {{ $projectService->hours ?? 1 }};
        else if(rateType === 'daily') durationInput.value = {{ $projectService->days ?? 1 }};
        else if(rateType === 'monthly') durationInput.value = {{ $projectService->months ?? 1 }};
        
        // Pre-fill rate input
        const rateInput = document.querySelector('input[name="rate"]');
        if(rateType === 'hourly') rateInput.value = {{ $projectService->hourly_rate ?? 0 }};
        else if(rateType === 'daily') rateInput.value = {{ $projectService->daily_rate ?? 0 }};
        else if(rateType === 'monthly') rateInput.value = {{ $projectService->monthly_rate ?? 0 }};
    }

    serviceTypeSelect.addEventListener('change', populateServices);
    rateTypeSelect.addEventListener('change', updateDurationLabel);
    window.addEventListener('DOMContentLoaded', () => {
        populateServices();
        updateDurationLabel();
    });
</script>
@endsection