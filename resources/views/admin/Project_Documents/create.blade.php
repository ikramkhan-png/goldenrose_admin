@extends('admin.layouts.app')

@section('content')
<div class="container-xl mt-4">
    <x-page-header title="Add Project Update" description="upload photos or videos related to this specific project." />
    <div class="card border-0 shadow-sm p-4">
        <form method="POST" enctype="multipart/form-data"
            action="{{ route('admin.project-documents.store') }}">
            @csrf

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

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>File</label>
                <input type="file" name="file" class="form-control">
            </div>

            <div class="mb-3">
                <label>Update Date</label>
                <input type="date" name="update_date" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="info">Info</option>
                    <option value="progress">Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection