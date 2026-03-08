@extends('admin.layouts.app')

@section('content')
<h4>Project Updates</h4>

<a href="{{ route('admin.project-documents.create') }}" class="btn btn-primary mb-3">
    + Add Project Update
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Project</th>
            <th>Title</th>
            <th>Status</th>
            <th>Date</th>
            <th>File</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projectDocuments as $doc)
        <tr>
            <td>{{ $doc->project->name }}</td>
            <td>{{ $doc->title }}</td>
            <td>{{ ucfirst($doc->status) }}</td>
            <td>{{ $doc->update_date }}</td>
            <td>
                @if($doc->file)
                    <a href="{{ asset('storage/'.$doc->file) }}" target="_blank">View</a>
                @endif
            </td>
            <td class="d-flex gap-2">
                <!-- Edit button -->
                <a href="{{ route('admin.project-documents.edit', $doc->id) }}"
                   class="btn btn-sm btn-warning">Edit</a>

                <!-- Delete button -->
                <form action="{{ route('admin.project-documents.destroy', $doc->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this update?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection