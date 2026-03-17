@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    @php $tab = request('tab', 'services'); @endphp
    <div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="page-title">{{ $client->name }}</h4>
                <p class="page-subtitle">{{ __('clients.client_dashboard_description') }}</p>
            </div>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-cancel">
                <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back') }}
            </a>
        </div>

        {{-- ===== CLIENT HEADER ===== --}}
        <div class="card mb-4">
            <div class="card-body" style="background: #1a2535; border-radius: 11px;">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">{{ __('clients.email') }}</div>
                        <div style="color:#e2e8f0;font-weight:600;margin-top:3px;">{{ $client->email }}</div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">{{ __('clients.phone') }}</div>
                        <div style="color:#e2e8f0;font-weight:600;margin-top:3px;">{{ $client->phone ?? '-' }}</div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#64748b;">{{ __('clients.client_type') }}</div>
                        <div style="color:#e2e8f0;font-weight:600;margin-top:3px;">{{ ucfirst($client->client_type) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MONTH FILTER ===== --}}
        <div class="card mb-4">
            <div class="card-body p-3">
                <form action="{{ route('admin.clients.show', $client->id) }}" method="GET" class="d-flex align-items-end gap-3 flex-wrap">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div style="flex: 1; min-width: 220px;">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt me-1" style="color: #4f46e5;"></i>{{ __('admin.filter_by_month') }}
                        </label>
                        <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                               onchange="this.form.submit()">
                    </div>
                    <div style="flex: 1; min-width: 180px;">
                        <label class="form-label">
                            <i class="fas fa-filter me-1" style="color: #4f46e5;"></i>{{ __('admin.filter') }}
                        </label>
                        <div class="filter-display">
                            {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                        </div>
                    </div>
                    @if(request('month'))
                    <div style="min-width: 110px;">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('admin.clients.show', $client->id) }}?tab={{ $tab }}" class="btn btn-secondary w-100">
                            <i class="fas fa-times me-1"></i>{{ __('Show All') }}
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- ===== TOP TABS ===== --}}
        <div class="payroll-tabs mb-4">
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=services{{ request('month') ? '&month=' . request('month') : '' }}"
                class="payroll-tab {{ $tab === 'services' ? 'active' : '' }}">
                <i class="fas fa-cogs me-1"></i>{{ __('clients.assigned_services') }}
            </a>
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=projects{{ request('month') ? '&month=' . request('month') : '' }}"
                class="payroll-tab {{ $tab === 'projects' ? 'active' : '' }}">
                <i class="fas fa-project-diagram me-1"></i>{{ __('clients.assigned_projects') }}
            </a>
            <a href="{{ route('admin.clients.show', $client->id) }}?tab=notes{{ request('month') ? '&month=' . request('month') : '' }}"
                class="payroll-tab {{ $tab === 'notes' ? 'active' : '' }}">
                <i class="fas fa-bell me-1"></i>{{ __('clients.notes_queries') }}
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
                        style="background: #4f46e5; color: white;">
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
                        style="background: #059669; color: white;">
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
                <h5 class="page-title" style="font-size:16px;">{{ __('clients.services') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.client-services.create') }}?client_id={{ $client->id }}"
                        class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>{{ __('clients.assign_service') }}</a>
                    <a href="{{ route('admin.client-services.financeSummary', $client->id) }}"
                        class="btn btn-sm btn-secondary">{{ __('clients.finance_summary') }}</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-styled mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('clients.service') }}</th>
                                    <th>{{ __('clients.rate_type') }}</th>
                                    <th>{{ __('clients.duration') }}</th>
                                    <th>{{ __('clients.rate') }}</th>
                                    <th>{{ __('clients.assigned_date') }}</th>
                                    <th>{{ __('clients.total_amount') }}</th>
                                    <th class="td-center">{{ __('clients.actions') }}</th>
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
                                        <td class="td-muted">{{ $loop->iteration }}</td>
                                        <td class="td-name">{{ $service->service->name ?? '-' }}</td>
                                        <td><span class="badge" style="background:#f1f5f9;color:#475569;font-size:11px;padding:3px 9px;border-radius:20px;font-weight:600;">{{ $rateType }}</span></td>
                                        <td class="td-muted">{{ $duration }}</td>
                                        <td class="td-pos">{{ $rate }}</td>
                                        <td class="td-muted">{{ $service->assigned_date ?? '-' }}</td>
                                        <td class="td-pos" style="font-weight:700;">
                                            @if ($service->hours > 0)
                                                {{ number_format($service->hours * $service->hourly_rate, 2) }}
                                            @elseif($service->days > 0)
                                                {{ number_format($service->days * $service->daily_rate, 2) }}
                                            @else
                                                {{ number_format($service->months * $service->monthly_rate, 2) }}
                                            @endif
                                        </td>
                                        <td class="td-center">
                                            <a href="{{ route('admin.client-services.view', $service->id) }}"
                                                class="btn btn-sm btn-info"><i class="fas fa-eye me-1"></i>{{ __('clients.view') }}</a>
                                            <a href="{{ route('admin.client-services.edit', $service->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>{{ __('clients.edit') }}</a>
                                            <form action="{{ route('admin.client-services.destroy', $service->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('{{ __('clients.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>{{ __('clients.delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 td-muted">
                                            <i class="fas fa-inbox" style="font-size:24px;opacity:0.3;display:block;margin-bottom:8px;"></i>
                                            {{ __('clients.no_services') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- ================= PROJECTS TAB ================= --}}
        @if ($tab === 'projects')
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5 class="page-title" style="font-size:16px;">{{ __('clients.projects') }}</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.projects.create') }}?client_id={{ $client->id }}"
                        class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>{{ __('clients.assign_project') }}</a>
                    <a href="{{ route('admin.clients.projectsFinanceSummary', $client->id) }}"
                        class="btn btn-sm btn-secondary">{{ __('clients.finance_summary') }}</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-styled mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('clients.project_name') }}</th>
                                    <th>{{ __('clients.type') }}</th>
                                    <th>{{ __('clients.budget') }}</th>
                                    <th>{{ __('clients.start_date') }}</th>
                                    <th>{{ __('clients.end_date') }}</th>
                                    <th class="td-center">{{ __('clients.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($client->projects as $project)
                                    <tr>
                                        <td class="td-muted">{{ $loop->iteration }}</td>
                                        <td class="td-name">{{ $project->name }}</td>
                                        <td><span class="badge" style="background:#f1f5f9;color:#475569;font-size:11px;padding:3px 9px;border-radius:20px;font-weight:600;">{{ ucfirst($project->type) }}</span></td>
                                        <td class="td-pos">{{ number_format($project->budget ?? 0, 2) }}</td>
                                        <td class="td-muted">{{ $project->start_date }}</td>
                                        <td class="td-muted">{{ $project->end_date ?? '-' }}</td>
                                        <td class="td-center">
                                            <a href="{{ route('admin.projects.internalShowFromClient', $project->id) }}"
                                                class="btn btn-sm btn-info"><i class="fas fa-eye me-1"></i>{{ __('clients.view') }}</a>
                                            <a href="{{ route('admin.projects.edit', $project->id) }}"
                                                class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>{{ __('clients.edit') }}</a>
                                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('{{ __('clients.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>{{ __('clients.delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 td-muted">
                                            <i class="fas fa-inbox" style="font-size:24px;opacity:0.3;display:block;margin-bottom:8px;"></i>
                                            {{ __('clients.no_projects') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        {{-- ================= NOTES & QUERIES TAB ================= --}}
        @if ($tab === 'notes')
            <div class="row">

                {{-- Send Note Form --}}
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-bell me-2" style="color:#4f46e5;"></i>
                            {{ __('clients.send_note_title') }}
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
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('clients.send_note_btn') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Previous Notes --}}
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-history me-2" style="color:#4f46e5;"></i>
                            {{ __('clients.sent_notes') }}
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            @forelse($client->clientNotes ?? [] as $note)
                                <div class="mb-3 pb-3" style="border-left: 3px solid {{ $note->is_read ? '#94a3b8' : '#22c55e' }}; padding-left: 12px;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <strong style="color:#1e293b;">{{ $note->subject }}</strong>
                                        <span class="badge ms-2" style="background:{{ $note->is_read ? '#f1f5f9' : '#dcfce7' }};color:{{ $note->is_read ? '#64748b' : '#166534' }};font-size:10px;padding:3px 8px;border-radius:20px;">
                                            {{ $note->is_read ? __('clients.read') : __('clients.unread') }}
                                        </span>
                                    </div>
                                    <p class="td-muted small mb-1" style="font-size:13px;">{{ Str::limit($note->message, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="td-muted">{{ $note->created_at->translatedFormat('M d, Y h:i A') }}</small>
                                        <form action="{{ route('admin.client-notes.destroy', $note->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('clients.confirm_delete_note') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="td-muted text-center">{{ __('clients.no_notes') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Client Queries --}}
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-question-circle me-2" style="color:#4f46e5;"></i>
                    {{ __('clients.client_queries') }}
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
                                <span class="badge ms-2" style="background:{{ $query->status == 'pending' ? '#fef3c7' : '#dcfce7' }};color:{{ $query->status == 'pending' ? '#92400e' : '#166534' }};font-size:11px;padding:4px 10px;border-radius:20px;font-weight:600;">
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
