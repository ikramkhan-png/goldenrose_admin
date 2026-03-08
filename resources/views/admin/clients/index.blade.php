@extends('admin.layouts.app')

@section('content')
<div class="container">
    <x-page-header title="Clients" description="List of all clients registered in the system." />
    <div class="d-flex justify-content-between mb-3">
        <h4>Clients</h4>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">+ Add Client</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Client Type</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone ?? '-' }}</td>
                    <td>{{ ucfirst($client->client_type ?? '-') }}</td>
                    <td>
                        <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No clients found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection