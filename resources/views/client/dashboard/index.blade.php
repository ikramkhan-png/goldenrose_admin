@extends('admin.layouts.app2')

@section('content')
<div class="container mt-4">

    {{-- ===== INTRO TEXT ===== --}}
    <div class="card mb-4 p-4" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color: white;">
        <h5 class="mb-2">Welcome, {{ $user->name }}</h5>
        <p class="mb-0" style="opacity: 0.9;">View your assigned services, projects and communicate with Golden Rose Construction.</p>
    </div>

    {{-- ===== CLIENT INFO ===== --}}
    <div class="card mb-4 p-3">
        <div class="row">
            <div class="col-md-3"><strong>Email:</strong> {{ $user->email }}</div>
            <div class="col-md-3"><strong>Phone:</strong> {{ $user->phone ?? '-' }}</div>
            <div class="col-md-3"><strong>Client Type:</strong> {{ ucfirst($user->client_type ?? 'General') }}</div>
            <div class="col-md-3 text-end">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== TOP TABS ===== --}}
    @php $tab = request('tab', 'services'); @endphp
    <div class="mb-3">
        <a href="{{ route('client.dashboard') }}?tab=services"
           class="btn btn-sm {{ $tab === 'services' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-cogs me-1"></i> My Services
        </a>
        <a href="{{ route('client.dashboard') }}?tab=projects"
           class="btn btn-sm {{ $tab === 'projects' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-project-diagram me-1"></i> My Projects
        </a>
        <a href="{{ route('client.dashboard') }}?tab=finance"
           class="btn btn-sm {{ $tab === 'finance' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-calculator me-1"></i> Finance Summary
        </a>
        <a href="{{ route('client.dashboard') }}?tab=messages"
           class="btn btn-sm {{ $tab === 'messages' ? 'btn-primary' : 'btn-outline-primary' }}">
            <i class="fas fa-envelope me-1"></i> Messages
        </a>
    </div>

    {{-- ================= SERVICES TAB ================= --}}
    @if($tab === 'services')
        @php
            $totalServiceAmount = 0;
            foreach($services as $svc) {
                if($svc->hours > 0) {
                    $totalServiceAmount += $svc->hours * $svc->hourly_rate;
                } elseif($svc->days > 0) {
                    $totalServiceAmount += $svc->days * $svc->daily_rate;
                } else {
                    $totalServiceAmount += $svc->months * $svc->monthly_rate;
                }
            }
        @endphp

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">Total Service Amount</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalServiceAmount, 2) }}</h3>
                        </div>
                        <i class="fas fa-calculator fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">Total Services</small>
                            <h3 class="mb-0 fw-bold">{{ $services->count() }}</h3>
                        </div>
                        <i class="fas fa-cogs fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">Total Paid</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalServicePaid, 2) }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>Assigned Services</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Rate Type</th>
                            <th>Duration</th>
                            <th>Rate</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($services as $service)
                        @php
                            if($service->hours > 0) {
                                $rateType = 'Hourly';
                                $duration = $service->hours . ' hrs';
                                $rate = $service->hourly_rate;
                                $amount = $service->hours * $service->hourly_rate;
                            } elseif($service->days > 0) {
                                $rateType = 'Daily';
                                $duration = $service->days . ' days';
                                $rate = $service->daily_rate;
                                $amount = $service->days * $service->daily_rate;
                            } else {
                                $rateType = 'Monthly';
                                $duration = $service->months . ' months';
                                $rate = $service->monthly_rate;
                                $amount = $service->months * $service->monthly_rate;
                            }
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $service->service->name ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $rateType }}</span></td>
                            <td>{{ $duration }}</td>
                            <td>{{ number_format($rate, 2) }}</td>
                            <td class="fw-bold text-primary">{{ number_format($amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No services assigned yet</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ================= PROJECTS TAB ================= --}}
    @if($tab === 'projects')
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">Total Projects</small>
                            <h3 class="mb-0 fw-bold">{{ $projects->count() }}</h3>
                        </div>
                        <i class="fas fa-project-diagram fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">Total Budget</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalProjectBudget, 2) }}</h3>
                        </div>
                        <i class="fas fa-money-bill fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="opacity-75">Total Paid</small>
                            <h3 class="mb-0 fw-bold">{{ number_format($totalProjectPaid, 2) }}</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>Assigned Projects</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
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
                    @forelse($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->name }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($project->type) }}</span></td>
                            <td>{{ number_format($project->budget ?? 0, 2) }}</td>
                            <td>{{ $project->start_date }}</td>
                            <td>{{ $project->end_date ?? '-' }}</td>
                            <td>
                                <a href="{{ route('client.project.show', $project->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">No projects assigned yet</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ================= FINANCE TAB ================= --}}
    @if($tab === 'finance')
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <small class="opacity-75">Total Service Amount</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalServiceAmount, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <small class="opacity-75">Total Project Budget</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalContractValue, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <small class="opacity-75">Total Paid</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalServicePaid + $totalProjectPaid, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <small class="opacity-75">Remaining Balance</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalServiceRemaining + $totalRemaining, 2) }}</h4>
                </div>
            </div>
        </div>

        {{-- Service Payments --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
                <strong><i class="fas fa-cogs me-2"></i>Service Payment History</strong>
            </div>
            <div class="table-responsive">
                @php $allServiceBillings = $services->flatMap(fn($s) => $s->billings); @endphp
                @if($allServiceBillings->count() > 0)
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allServiceBillings as $index => $billing)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-success">{{ number_format($billing->amount_paid, 2) }}</td>
                                    <td>{{ $billing->payment_date ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $billing->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($billing->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $billing->notes ?? '-' }}</td>
                                    <td>
                                        @if($billing->invoice)
                                            <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center text-muted">No service payments yet</div>
                @endif
            </div>
        </div>

        {{-- Project Payments --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong><i class="fas fa-project-diagram me-2"></i>Project Payment History</strong>
            </div>
            <div class="table-responsive">
                @php $allProjectBillings = $projects->flatMap(fn($p) => $p->billings->map(fn($b) => $b->setAttribute('project_name', $p->name))); @endphp
                @if($allProjectBillings->count() > 0)
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project</th>
                                <th>Amount Billed</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allProjectBillings as $index => $billing)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $billing->project_name }}</td>
                                    <td>{{ number_format($billing->amount_billed, 2) }}</td>
                                    <td class="fw-bold text-success">{{ number_format($billing->amount_paid, 2) }}</td>
                                    <td>{{ $billing->payment_date ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $billing->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($billing->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($billing->invoice)
                                            <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-4 text-center text-muted">No project payments yet</div>
                @endif
            </div>
        </div>
    @endif

    {{-- ================= MESSAGES TAB ================= --}}
    @if($tab === 'messages')
        <div class="row">
            {{-- Important Notes from Admin --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-bell me-2"></i>Important Notes from Admin</h6>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @forelse($importantNotes as $note)
                            <div class="border-start border-4 {{ $note->is_read ? 'border-secondary' : 'border-success' }} ps-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $note->subject }}</strong>
                                    @if(!$note->is_read)
                                        <span class="badge bg-success">New</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-1">{{ $note->message }}</p>
                                @if($note->document)
                                    <a href="{{ asset('storage/'.$note->document) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                        <i class="fas fa-paperclip"></i> Attachment
                                    </a>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $note->created_at->format('M d, Y h:i A') }}</small>
                                    @if(!$note->is_read)
                                        <form action="{{ route('client.note.read', $note->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-link">Mark as read</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">No notes from admin</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Submit Query --}}
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Submit a Query</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('client.query.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" required placeholder="What is your query about?">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="3" required placeholder="Describe your query..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Attachment (Optional)</label>
                                <input type="file" name="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            </div>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-paper-plane me-2"></i>Submit Query
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- My Queries --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>My Queries</h6>
            </div>
            <div class="card-body">
                @forelse($myQueries as $query)
                    <div class="border rounded p-3 mb-3 {{ $query->status == 'pending' ? 'border-warning' : 'border-success' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $query->subject }}</h6>
                                <p class="text-muted mb-2">{{ $query->message }}</p>
                                @if($query->document)
                                    <a href="{{ asset('storage/'.$query->document) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                                        <i class="fas fa-paperclip"></i> View Attachment
                                    </a>
                                @endif
                                @if($query->admin_reply)
                                    <div class="bg-light p-2 rounded">
                                        <small class="text-muted">Admin Reply:</small>
                                        <p class="mb-0">{{ $query->admin_reply }}</p>
                                    </div>
                                @endif
                            </div>
                            <span class="badge bg-{{ $query->status == 'resolved' ? 'success' : 'warning' }} ms-2">
                                {{ ucfirst($query->status) }}
                            </span>
                        </div>
                        <small class="text-muted">Submitted: {{ $query->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                @empty
                    <p class="text-muted text-center">No queries submitted yet</p>
                @endforelse
            </div>
        </div>
    @endif

</div>
@endsection
