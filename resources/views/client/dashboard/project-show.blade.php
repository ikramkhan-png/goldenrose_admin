@extends('admin.layouts.app2')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== PROJECT HEADER ===== --}}
    <div class="client-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-semibold text-white">{{ $project->name }}</h3>
                <small class="text-white-50">Project Details</small>
            </div>
            <a href="{{ route('client.dashboard') }}?tab=projects" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Projects
            </a>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Type</small>
                    <div class="text-capitalize">{{ $project->type }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Budget</small>
                    <div>{{ number_format($project->budget ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Start Date</small>
                    <div>{{ $project->start_date ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>End Date</small>
                    <div>{{ $project->end_date ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TABS ===== --}}
    @php $tab = request('tab', 'details'); @endphp
    <div class="mb-4">
        <div class="btn-group">
            <a href="{{ route('client.project.show', $project->id) }}?tab=details"
               class="btn {{ $tab === 'details' ? 'btn-dark' : 'btn-outline-dark' }}">
                <i class="fas fa-info-circle me-1"></i> Details
            </a>
            <a href="{{ route('client.project.show', $project->id) }}?tab=updates"
               class="btn {{ $tab === 'updates' ? 'btn-dark' : 'btn-outline-dark' }}">
                <i class="fas fa-bullhorn me-1"></i> Project Updates
            </a>
            <a href="{{ route('client.project.show', $project->id) }}?tab=finance"
               class="btn {{ $tab === 'finance' ? 'btn-dark' : 'btn-outline-dark' }}">
                <i class="fas fa-calculator me-1"></i> Finance
            </a>
        </div>
    </div>

    {{-- ================= DETAILS TAB ================= --}}
    @if($tab === 'details')
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>Project Information</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">Project Name:</th>
                                <td>{{ $project->name }}</td>
                            </tr>
                            <tr>
                                <th>Type:</th>
                                <td><span class="badge bg-info">{{ ucfirst($project->type) }}</span></td>
                            </tr>
                            <tr>
                                <th>Budget:</th>
                                <td class="fw-bold text-primary">{{ number_format($project->budget ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">Start Date:</th>
                                <td>{{ $project->start_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>End Date:</th>
                                <td>{{ $project->end_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($project->end_date && $project->end_date < now())
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning">In Progress</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($project->notes)
                    <hr>
                    <h6 class="fw-bold">Project Notes</h6>
                    <p class="text-muted">{{ $project->notes }}</p>
                @endif
            </div>
        </div>
    @endif

    {{-- ================= PROJECT UPDATES TAB ================= --}}
    @if($tab === 'updates')
        <div class="mb-3">
            <h5 class="fw-bold"><i class="fas fa-bullhorn me-2 text-primary"></i>Project Updates</h5>
            <p class="text-muted">Stay updated with the latest progress on your project</p>
        </div>

        @forelse($project->documents->sortByDesc('created_at') as $update)
            <div class="card shadow-sm border-0 mb-4 update-card">
                <div class="card-body">
                    {{-- Update Header --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $update->title }}</h5>
                            <div class="text-muted small">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $update->update_date ? \Carbon\Carbon::parse($update->update_date)->format('F d, Y') : $update->created_at->format('F d, Y') }}
                                @if($update->status)
                                    <span class="badge bg-{{ $update->status == 'completed' ? 'success' : ($update->status == 'in_progress' ? 'warning' : 'info') }} ms-2">
                                        {{ ucfirst(str_replace('_', ' ', $update->status)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-clock me-1"></i>{{ $update->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Description --}}
                    @if($update->description)
                        <p class="mb-3">{{ $update->description }}</p>
                    @endif

                    {{-- Media Preview --}}
                    @if($update->file)
                        @php
                            $fileExtension = strtolower(pathinfo($update->file, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            $isVideo = in_array($fileExtension, ['mp4', 'webm', 'mov', 'avi']);
                        @endphp

                        <div class="update-media mb-3">
                            @if($isImage)
                                <img src="{{ asset('storage/'.$update->file) }}" alt="{{ $update->title }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                            @elseif($isVideo)
                                <video controls class="w-100 rounded" style="max-height: 400px;">
                                    <source src="{{ asset('storage/'.$update->file) }}" type="video/{{ $fileExtension == 'mov' ? 'quicktime' : $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <div class="file-attachment p-3 bg-light rounded d-flex align-items-center">
                                    <div class="file-icon me-3">
                                        @if(in_array($fileExtension, ['pdf']))
                                            <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                        @elseif(in_array($fileExtension, ['doc', 'docx']))
                                            <i class="fas fa-file-word fa-3x text-primary"></i>
                                        @elseif(in_array($fileExtension, ['xls', 'xlsx']))
                                            <i class="fas fa-file-excel fa-3x text-success"></i>
                                        @else
                                            <i class="fas fa-file fa-3x text-secondary"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong>{{ basename($update->file) }}</strong>
                                        <p class="text-muted mb-0 small">{{ strtoupper($fileExtension) }} File</p>
                                    </div>
                                    <a href="{{ asset('storage/'.$update->file) }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- View/Download Button for Images/Videos --}}
                        @if($isImage || $isVideo)
                            <a href="{{ asset('storage/'.$update->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt me-1"></i> View Full Size
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No Updates Yet</h5>
                    <p class="text-muted">Project updates will appear here once they are posted.</p>
                </div>
            </div>
        @endforelse
    @endif

    {{-- ================= FINANCE TAB ================= --}}
    @if($tab === 'finance')
        @php
            $budget = $project->budget ?? 0;
            $additionalBilled = $project->billings->sum('amount_billed');
            $totalBilled = $budget + $additionalBilled;
            $totalPaid = $project->billings->sum('amount_paid') ?? 0;
            $totalRemaining = $totalBilled - $totalPaid;
        @endphp

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <small class="opacity-75">Project Budget</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($budget, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <small class="opacity-75">Additional Billings</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($additionalBilled, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <small class="opacity-75">Total Paid</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalPaid, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <small class="opacity-75">Remaining Balance</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalRemaining, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>Payment History</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Amount Billed</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($project->billings as $billing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ number_format($billing->amount_billed, 2) }}</td>
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
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">No payment records yet</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

{{-- ===== STYLE BLOCK ===== --}}
<style>
.client-header{
    background: linear-gradient(135deg, #1f2937, #374151);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.info-box{
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
    padding: 14px;
    color: #fff;
}
.update-card {
    border-left: 4px solid #667eea !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.update-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}
.update-media img,
.update-media video {
    width: 100%;
    border-radius: 8px;
}
.file-attachment {
    border: 1px dashed #dee2e6;
}
</style>
@endsection
