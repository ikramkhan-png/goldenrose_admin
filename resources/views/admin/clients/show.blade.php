@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container mt-4" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        {{-- ===== INTRO TEXT ===== --}}
        <div class="card mb-4 p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
            <h5 class="mb-2">{{ __('clients.client_dashboard') }}</h5>
            <p class="mb-0" style="opacity: 0.9;">{{ __('clients.client_dashboard_description') }}</p>
        </div>

        {{-- ===== CLIENT HEADER ===== --}}
        <div class="card mb-4 p-3">
            <h4>{{ __('clients.client_details') }}: {{ $client->name }}</h4>
            <p><strong>{{ __('clients.email') }}:</strong> {{ $client->email }}</p>
            <p><strong>{{ __('clients.phone') }}:</strong> {{ $client->phone ?? '-' }}</p>
            <p><strong>{{ __('clients.client_type') }}:</strong> {{ ucfirst($client->client_type) }}</p>
        </div>

        {{-- ===== TOP TABS ===== --}}
        @php $tab = request('tab', 'services'); @endphp
        <div class="mb-3">
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=services"
                class="btn btn-sm {{ $tab === 'services' ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ __('clients.assigned_services') }}
            </a>
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=projects"
                class="btn btn-sm {{ $tab === 'projects' ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ __('clients.assigned_projects') }}
            </a>
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=notes"
                class="btn btn-sm {{ $tab === 'notes' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-bell"></i> {{ __('clients.notes_queries') }}
            </a>
        </div>

        {{-- ================= SERVICES TAB ================= --}}
        @if ($tab === 'services')
            @php
                $totalServiceAmount = 0;
                foreach ($client->services as $svc) {
                    if ($svc->hours > 0) {
                        $totalServiceAmount += $svc->hours * $svc->hourly_rate;
                    } elseif ($svc->days > 0) {
                        $totalServiceAmount += $svc->days * $svc->daily_rate;
                    } else {
                        $totalServiceAmount += $svc->months * $svc->monthly_rate;
                    }
                }
            @endphp

            {{-- Summary Cards --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">{{ __('clients.total_service_amount') }}</small>
                                <h3 class="mb-0 fw-bold">{{ number_format($totalServiceAmount, 2) }}</h3>
                            </div>
                            <i class="fas fa-calculator fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3"
                        style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75">{{ __('clients.total_services') }}</small>
                                <h3 class="mb-0 fw-bold">{{ $client->services->count() }}</h3>
                            </div>
                            <i class="fas fa-cogs fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5>{{ __('clients.services') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.client-services.create') }}?client_id={{ $client->id }}"
                        class="btn btn-sm btn-success">+ {{ __('clients.assign_service') }}</a>
                    <a href="{{ route('admin.client-services.financeSummary', $client->id) }}"
                        class="btn btn-sm btn-outline-dark">{{ __('clients.finance_summary') }}</a>
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('clients.service') }}</th>
                        <th>{{ __('clients.rate_type') }}</th>
                        <th>{{ __('clients.duration') }}</th>
                        <th>{{ __('clients.rate') }}</th>
                        <th>{{ __('clients.total_amount') }}</th>
                        <th width="160">{{ __('clients.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->services as $service)
                        @php
                            if ($service->hours > 0) {
                                $rateType = __('clients.hourly');
                                $duration = $service->hours;
                                $rate = number_format($service->hourly_rate, 2);
                            } elseif ($service->days > 0) {
                                $rateType = __('clients.daily');
                                $duration = $service->days;
                                $rate = number_format($service->daily_rate, 2);
                            } else {
                                $rateType = __('clients.monthly');
                                $duration = $service->months;
                                $rate = number_format($service->monthly_rate, 2);
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $service->service->name ?? '-' }}</td>
                            <td>{{ $rateType }}</td>
                            <td>{{ $duration }}</td>
                            <td>{{ $rate }}</td>
                            <td>
                                @if ($service->hours > 0)
                                    {{ number_format($service->hours * $service->hourly_rate, 2) }}
                                @elseif($service->days > 0)
                                    {{ number_format($service->days * $service->daily_rate, 2) }}
                                @else
                                    {{ number_format($service->months * $service->monthly_rate, 2) }}
                                @endif
                            </td>
                            <td class="d-flex gap-1 flex-wrap align-items-center actions-cell" style="min-width: 140px;">
                                <a href="{{ route('admin.client-services.view', $service->id) }}"
                                    class="btn btn-sm btn-info px-2">{{ __('clients.view') }}</a>
                                <a href="{{ route('admin.client-services.edit', $service->id) }}"
                                    class="btn btn-sm btn-warning px-2">{{ __('clients.edit') }}</a>
                                <form action="{{ route('admin.client-services.destroy', $service->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('{{ __('clients.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger px-2">{{ __('clients.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                {{ __('clients.no_services') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        {{-- ================= PROJECTS TAB ================= --}}
        @if ($tab === 'projects')
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5>{{ __('clients.projects') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.projects.create') }}?client_id={{ $client->id }}"
                        class="btn btn-sm btn-success">+ {{ __('clients.assign_project') }}</a>
                    <a href="{{ route('admin.clients.projectsFinanceSummary', $client->id) }}"
                        class="btn btn-sm btn-outline-dark">{{ __('clients.finance_summary') }}</a>
                </div>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('clients.project_name') }}</th>
                        <th>{{ __('clients.type') }}</th>
                        <th>{{ __('clients.budget') }}</th>
                        <th>{{ __('clients.start_date') }}</th>
                        <th>{{ __('clients.end_date') }}</th>
                        <th>{{ __('clients.actions') }}</th>
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
                                    class="btn btn-sm btn-info px-2">{{ __('clients.view') }}</a>
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                    class="btn btn-sm btn-warning px-2">{{ __('clients.edit') }}</a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('{{ __('clients.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger px-2">{{ __('clients.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                {{ __('clients.no_projects') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        {{-- ================= NOTES & QUERIES TAB ================= --}}
        @if ($tab === 'notes')
            <div class="row">

                {{-- Send Note Form --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">
                                <i class="fas fa-bell me-2"></i>
                                {{ __('clients.send_note_title') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.client-notes.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        {{ __('clients.subject') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="subject" class="form-control" required
                                        placeholder="{{ __('clients.subject_placeholder') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        {{ __('clients.message') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="message" class="form-control" rows="4" required
                                        placeholder="{{ __('clients.message_placeholder') }}"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        {{ __('clients.attachment_optional') }}
                                    </label>
                                    <input type="file" name="document" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </div>
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('clients.send_note_btn') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Previous Notes --}}
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-history me-2"></i>
                                {{ __('clients.sent_notes') }}
                            </h6>
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            @forelse($client->clientNotes ?? [] as $note)
                                <div
                                    class="border-start border-4 {{ $note->is_read ? 'border-secondary' : 'border-success' }} ps-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $note->subject }}</strong>
                                        <span class="badge bg-{{ $note->is_read ? 'secondary' : 'success' }}">
                                            {{ $note->is_read ? __('clients.read') : __('clients.unread') }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-1">{{ Str::limit($note->message, 100) }}</p>
                                    <small class="text-muted">
                                        {{ $note->created_at->translatedFormat('M d, Y h:i A') }}
                                    </small>
                                    <form action="{{ route('admin.client-notes.destroy', $note->id) }}" method="POST"
                                        class="d-inline float-end">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('{{ __('clients.confirm_delete_note') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-muted text-center">{{ __('clients.no_notes') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Client Queries --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        {{ __('clients.client_queries') }}
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($client->clientQueries ?? [] as $query)
                        <div
                            class="border rounded p-3 mb-3
                        {{ $query->status == 'pending' ? 'border-warning' : 'border-success' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $query->subject }}</h6>
                                    <p class="mb-2">{{ $query->message }}</p>
                                    @if ($query->document)
                                        <a href="{{ asset('storage/' . $query->document) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="fas fa-paperclip"></i>
                                            {{ __('clients.view_attachment') }}
                                        </a>
                                    @endif
                                    @if ($query->admin_reply)
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted">{{ __('clients.your_reply') }}:</small>
                                            <p class="mb-0">{{ $query->admin_reply }}</p>
                                        </div>
                                    @else
                                        <form action="{{ route('admin.client-queries.reply', $query->id) }}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            <div class="input-group">
                                                <input type="text" name="reply" class="form-control"
                                                    placeholder="{{ __('clients.reply_placeholder') }}" required>
                                                <button type="submit" class="btn btn-success">
                                                    {{ __('clients.reply') }}
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $query->status == 'pending' ? 'warning' : 'success' }} ms-2">
                                    {{ $query->status == 'pending' ? __('clients.pending') : __('clients.resolved') }}
                                </span>
                            </div>
                            <small class="text-muted">
                                {{ __('clients.received') }}:
                                {{ $query->created_at->translatedFormat('M d, Y h:i A') }}
                            </small>
                        </div>
                    @empty
                        <p class="text-muted text-center">{{ __('clients.no_queries') }}</p>
                    @endforelse
                </div>
            </div>
        @endif

    </div>
@endsection
