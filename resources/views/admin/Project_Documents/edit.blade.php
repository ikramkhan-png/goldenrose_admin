@extends('admin.layouts.app')

@section('content')
<h4>Edit Project Update</h4>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.project-documents.update', $projectDocument->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Project</label>
        <select name="project_id" class="form-control" required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}"
                        @selected($project->id == $projectDocument->project_id)>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title"
               value="{{ $projectDocument->title }}"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $projectDocument->description }}</textarea>
    </div>

    <div class="mb-3">
        <label>Replace File</label>
        <input type="file" name="file" class="form-control">
        @if($projectDocument->file)
            <small>
                <a href="{{ asset('storage/'.$projectDocument->file) }}" target="_blank">
                    View current file
                </a>
            </small>
        @endif
    </div>

    <div class="mb-3">
        <label>Update Date</label>
        <input type="date" name="update_date"
               value="{{ $projectDocument->update_date }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="info" @selected($projectDocument->status=='info')>Info</option>
            <option value="progress" @selected($projectDocument->status=='progress')>Progress</option>
            <option value="completed" @selected($projectDocument->status=='completed')>Completed</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection