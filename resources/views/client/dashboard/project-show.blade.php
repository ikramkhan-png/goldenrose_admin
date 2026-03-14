@extends('admin.layouts.app2')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@php $tab = request('tab', 'details'); @endphp
<div class="container-fluid px-4 py-3" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- ===== PROJECT HEADER ===== --}}
    <div class="client-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-semibold text-white">{{ $project->name }}</h3>
                <small class="text-white-50">{{ __('client.project_details') }}</small>
            </div>
            <a href="{{ route('client.dashboard') }}?tab=projects" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> {{ __('client.back_to_projects') }}
            </a>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('client.type') }}</small>
                    <div class="text-capitalize">{{ __('client.' . $project->type . '_type') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('client.budget') }}</small>
                    <div>{{ number_format($project->budget ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('client.start_date') }}</small>
                    <div>{{ $project->start_date ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>{{ __('client.end_date') }}</small>
                    <div>{{ $project->end_date ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MONTH FILTER ===== --}}
    <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
        <div class="card-body p-4">
            <form action="{{ route('client.project.show', $project->id) }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div style="flex: 1; min-width: 250px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('admin.filter_by_month') }}</label>
                    <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                           onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                </div>
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('admin.filter') }}</label>
                    <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                        {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : now()->format('F Y') }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== TABS ===== --}}
    <div class="mb-4">
        <div class="btn-group">
            <a href="{{ route('client.project.show', $project->id) }}?tab=details{{ request('month') ? '&month=' . request('month') : '' }}"
               class="btn {{ $tab === 'details' ? 'btn-dark' : 'btn-outline-dark' }}">
                <i class="fas fa-info-circle me-1"></i> {{ __('client.details') }}
            </a>
            <a href="{{ route('client.project.show', $project->id) }}?tab=updates{{ request('month') ? '&month=' . request('month') : '' }}"
               class="btn {{ $tab === 'updates' ? 'btn-dark' : 'btn-outline-dark' }}">
                <i class="fas fa-bullhorn me-1"></i> {{ __('client.project_updates') }}
            </a>
            <a href="{{ route('client.project.show', $project->id) }}?tab=finance{{ request('month') ? '&month=' . request('month') : '' }}"
               class="btn {{ $tab === 'finance' ? 'btn-dark' : 'btn-outline-dark' }}">
                <i class="fas fa-calculator me-1"></i> {{ __('client.finance') }}
            </a>
        </div>
    </div>

    {{-- ================= DETAILS TAB ================= --}}
    @if($tab === 'details')
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>{{ __('client.project_information') }}</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">{{ __('client.project_name_label') }}</th>
                                <td>{{ $project->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('client.type') }}:</th>
                                <td><span class="badge bg-info">{{ __('client.' . $project->type . '_type') }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ __('client.budget') }}:</th>
                                <td class="fw-bold text-primary">{{ number_format($project->budget ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">{{ __('client.start_date') }}:</th>
                                <td>{{ $project->start_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('client.end_date') }}:</th>
                                <td>{{ $project->end_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('client.status') }}:</th>
                                <td>
                                    @if($project->end_date && $project->end_date < now())
                                        <span class="badge bg-success">{{ __('client.completed') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('client.in_progress') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($project->notes)
                    <hr>
                    <h6 class="fw-bold">{{ __('client.project_notes') }}</h6>
                    <p class="text-muted">{{ $project->notes }}</p>
                @endif
            </div>
        </div>
    @endif

    {{-- ================= PROJECT UPDATES TAB ================= --}}
    @if($tab === 'updates')
        <div class="mb-3">
            <h5 class="fw-bold"><i class="fas fa-bullhorn me-2 text-primary"></i>{{ __('client.project_updates') }}</h5>
            <p class="text-muted">{{ __('client.stay_updated_progress') }}</p>
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
                                        <p class="text-muted mb-0 small">{{ strtoupper($fileExtension) }} {{ __('client.file') }}</p>
                                    </div>
                                    <a href="{{ asset('storage/'.$update->file) }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-download me-1"></i> {{ __('client.download') }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- View/Download Button for Images/Videos --}}
                        @if($isImage || $isVideo)
                            <a href="{{ asset('storage/'.$update->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt me-1"></i> {{ __('client.view_full_size') }}
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">{{ __('client.no_updates_yet') }}</h5>
                    <p class="text-muted">{{ __('client.no_updates_message') }}</p>
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
                    <small class="opacity-75">{{ __('client.project_budget') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($budget, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <small class="opacity-75">{{ __('client.additional_billings') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($additionalBilled, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                    <small class="opacity-75">{{ __('client.total_paid') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalPaid, 2) }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-3" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <small class="opacity-75">{{ __('client.remaining_balance') }}</small>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalRemaining, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <strong>{{ __('client.payment_history') }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('client.amount_billed') }}</th>
                            <th>{{ __('client.amount_paid') }}</th>
                            <th>{{ __('client.payment_date') }}</th>
                            <th>{{ __('client.status') }}</th>
                            <th>{{ __('client.notes') }}</th>
                            <th>{{ __('client.invoice') }}</th>
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
                                    {{ __('admin.' . $billing->status) }}
                                </span>
                            </td>
                            <td>{{ $billing->notes ?? '-' }}</td>
                            <td>
                                @if($billing->invoice)
                                    <a href="{{ asset('storage/'.$billing->invoice) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> {{ __('client.view') }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">{{ __('client.no_payment_records') }}</td>
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
