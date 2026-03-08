@extends('admin.layouts.app')

@section('content')
<h4>Add Project Update</h4>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.project-documents.store') }}">
    @csrf

    <div class="mb-3">
        <label>Project</label>
        <select name="project_id" class="form-control" required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
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
@endsection