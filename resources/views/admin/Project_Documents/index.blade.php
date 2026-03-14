@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="d-flex justify-content-between mb-3">
        <h4>Project Updates</h4>
        <a href="{{ route('admin.project-documents.create') }}" class="btn btn-primary">
            + Add Project Update
        </a>
    </div>

    {{-- FILTER CARD --}}
    <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-4">
            <form action="{{ route('admin.project-documents.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 Select Month</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 Period</label>
                    <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                        {{ $selectedMonth->format('F Y') }}
                    </div>
                </div>
            </form>
        </div>
    </div>

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
            @forelse($projectDocuments as $doc)
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
            @empty
                <tr>
                    <td colspan="6" class="text-center">No project updates found for {{ $selectedMonth->format('F Y') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection