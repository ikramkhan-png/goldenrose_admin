@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ===== INTRO TEXT ===== --}}
    <div class="card mb-4 p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
        <h5 class="mb-2">Client Dashboard</h5>
        <p class="mb-0" style="opacity: 0.9;">Manage client details, assigned services and projects. Use the tabs below to switch views.</p>
    </div>

    {{-- ===== CLIENT HEADER ===== --}}
    <div class="card mb-4 p-3">
        <h4>Client Details: {{ $client->name }}</h4>
        <p><strong>Email:</strong> {{ $client->email }}</p>
        <p><strong>Phone:</strong> {{ $client->phone ?? '-' }}</p>
        <p><strong>Client Type:</strong> {{ ucfirst($client->client_type) }}</p>
    </div>

    {{-- ===== TOP TABS ===== --}}
    @php $tab = request('tab', 'services'); @endphp
    <div class="mb-3">
        <a href="{{ route('admin.clients.show', $client->id) }}?tab=services"
           class="btn btn-sm {{ $tab === 'services' ? 'btn-primary' : 'btn-outline-primary' }}">
            Assigned Services
        </a>
        <a href="{{ route('admin.clients.show', $client->id) }}?tab=projects"
           class="btn btn-sm {{ $tab === 'projects' ? 'btn-primary' : 'btn-outline-primary' }}">
            Assigned Projects
        </a>
        <a href="{{ route('admin.clients.show', $client->id) }}?tab=notes"
           class="btn btn-sm {{ $tab === 'notes' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-bell"></i> Notes & Queries
        </a>
    </div>

    {{-- ================= SERVICES TAB ================= --}}
    @if($tab === 'services')
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5>Services</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.client-services.create') }}?client_id={{ $client->id }}"
                   class="btn btn-sm btn-success">+ Assign Service</a>
                <a href="{{ route('admin.client-services.financeSummary', $client->id) }}"
                   class="btn btn-sm btn-outline-dark">Finance Summary</a>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Rate Type</th>
                    <th>Duration</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($client->services as $service)
                @php
                    // Determine rate type and duration
                    if($service->hours > 0) {
                        $rateType = 'Hourly';
                        $duration  = $service->hours;
                        $rate      = number_format($service->hourly_rate, 2);
                    } elseif($service->days > 0) {
                        $rateType = 'Daily';
                        $duration  = $service->days;
                        $rate      = number_format($service->daily_rate, 2);
                    } else {
                        $rateType = 'Monthly';
                        $duration  = $service->months;
                        $rate      = number_format($service->monthly_rate, 2);
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $service->service->name ?? '-' }}</td>
                    <td>{{ $rateType }}</td>
                    <td>{{ $duration }}</td>
                    <td>{{ $rate }}</td>
                    <td>
                        @if($service->hours > 0)
                            {{ number_format($service->hours * $service->hourly_rate, 2) }}
                        @elseif($service->days > 0)
                            {{ number_format($service->days * $service->daily_rate, 2) }}
                        @else
                            {{ number_format($service->months * $service->monthly_rate, 2) }}
                        @endif
                    </td>
                    <td class="d-flex gap-1 flex-wrap align-items-center actions-cell" style="min-width: 140px;">
                        <a href="{{ route('admin.client-services.view', $service->id) }}"
                           class="btn btn-sm btn-info px-2">View</a>
                        <a href="{{ route('admin.client-services.edit', $service->id) }}"
                           class="btn btn-sm btn-warning px-2">Edit</a>
                        <form action="{{ route('admin.client-services.destroy', $service->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger px-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No services assigned yet
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= PROJECTS TAB ================= --}}
    @if($tab === 'projects')
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h5>Projects</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.projects.create') }}?client_id={{ $client->id }}"
                   class="btn btn-sm btn-success">+ Assign Project</a>
                <a href="{{ route('admin.clients.projectsFinanceSummary', $client->id) }}"
                   class="btn btn-sm btn-outline-dark">Finance Summary</a>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project Name</th>
                    <th>Type</th>
                    <th>Budget</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($client->projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ ucfirst($project->type) }}</td>
                    <td>{{ number_format($project->budget ?? 0, 2) }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date ?? '-' }}</td>
                    <td class="d-flex gap-1 flex-wrap align-items-center actions-cell" style="min-width: 140px;">
                        <a href="{{ route('admin.projects.internalShowFromClient', $project->id) }}"
                           class="btn btn-sm btn-info px-2">View</a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}"
                           class="btn btn-sm btn-warning px-2">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger px-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No projects assigned yet
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    @endif

    {{-- ================= NOTES & QUERIES TAB ================= --}}
    @if($tab === 'notes')
        <div class="row">
            {{-- Send Important Note Form --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-bell me-2"></i>Send Important Note to Client</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.client-notes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" required 
                                       placeholder="e.g., Submit your pending bills">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="4" required
                                          placeholder="Enter the important information for the client..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Attachment (Optional)</label>
                                <input type="file" name="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-paper-plane me-2"></i>Send Note to Client
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Previous Notes --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Sent Notes</h6>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($client->clientNotes ?? [] as $note)
                            <div class="border-start border-4 {{ $note->is_read ? 'border-secondary' : 'border-success' }} ps-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $note->subject }}</strong>
                                    <span class="badge bg-{{ $note->is_read ? 'secondary' : 'success' }}">
                                        {{ $note->is_read ? 'Read' : 'Unread' }}
                                    </span>
                                </div>
                                <p class="text-muted small mb-1">{{ Str::limit($note->message, 100) }}</p>
                                <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                <form action="{{ route('admin.client-notes.destroy', $note->id) }}" method="POST" class="d-inline float-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this note?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-muted text-center">No notes sent yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Client Queries --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>Client Queries</h6>
            </div>
            <div class="card-body">
                @forelse($client->clientQueries ?? [] as $query)
                    <div class="border rounded p-3 mb-3 {{ $query->status == 'pending' ? 'border-warning' : 'border-success' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $query->subject }}</h6>
                                <p class="mb-2">{{ $query->message }}</p>
                                @if($query->document)
                                    <a href="{{ asset('storage/'.$query->document) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                                        <i class="fas fa-paperclip"></i> View Attachment
                                    </a>
                                @endif
                                @if($query->admin_reply)
                                    <div class="bg-light p-2 rounded">
                                        <small class="text-muted">Your Reply:</small>
                                        <p class="mb-0">{{ $query->admin_reply }}</p>
                                    </div>
                                @else
                                    <form action="{{ route('admin.client-queries.reply', $query->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="reply" class="form-control" placeholder="Type your reply..." required>
                                            <button type="submit" class="btn btn-success">Reply</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <span class="badge bg-{{ $query->status == 'pending' ? 'warning' : 'success' }} ms-2">
                                {{ ucfirst($query->status) }}
                            </span>
                        </div>
                        <small class="text-muted">Received: {{ $query->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                @empty
                    <p class="text-muted text-center">No queries from this client</p>
                @endforelse
            </div>
        </div>
    @endif

</div>
@endsection