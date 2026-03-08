@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== PROJECT HEADER ===== --}}
    <div class="client-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-semibold text-white">{{ $project->name }}</h3>
                <small class="text-white-50">Project Overview</small>
            </div>
        </div>

        <div class="row mt-3 g-3">
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Client</small>
                    <div>{{ $project->client->name ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box text-center">
                    <small>Type</small>
                    <div class="text-capitalize">{{ $project->type }}</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box text-center">
                    <small>Budget</small>
                    <div>{{ number_format($project->budget ?? 0, 2) }}</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="info-box text-center">
                    <small>Start Date</small>
                    <div>{{ $project->start_date }}</div>
                </div>
            </div>
            <div class="col-md-2">
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
            <a href="{{ route('admin.projects.view', $project->id) }}?tab=details"
               class="btn {{ $tab === 'details' ? 'btn-dark' : 'btn-outline-dark' }}">Details</a>
            <a href="{{ route('admin.projects.view', $project->id) }}?tab=services"
               class="btn {{ $tab === 'services' ? 'btn-dark' : 'btn-outline-dark' }}">Services</a>
            <a href="{{ route('admin.projects.view', $project->id) }}?tab=documents"
               class="btn {{ $tab === 'documents' ? 'btn-dark' : 'btn-outline-dark' }}">Documents</a>
            <a href="{{ route('admin.projects.view', $project->id) }}?tab=finance"
               class="btn {{ $tab === 'finance' ? 'btn-dark' : 'btn-outline-dark' }}">Finance</a>
        </div>
    </div>

    {{-- ================= DETAILS TAB ================= --}}
    @if($tab === 'details')
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-semibold">Project Notes</h5>
                <p>{{ $project->notes ?? 'No notes available.' }}</p>
            </div>
        </div>
    @endif

    {{-- ================= SERVICES TAB ================= --}}
    @if($tab === 'services')
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Assigned Services</strong>
                <a href="#" class="btn btn-sm btn-outline-dark">Add Service</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th>Rate</th>
                            <th>Duration</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($project->assignedServices as $service)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $service->service->name ?? '-' }}</td>
                            <td>{{ $service->hourly_rate ?: $service->daily_rate ?: $service->monthly_rate }}</td>
                            <td>{{ $service->hours ?? $service->days ?? $service->months }}</td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete service?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No services assigned</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ================= DOCUMENTS TAB ================= --}}
    @if($tab === 'documents')
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Project Documents</strong>
                <a href="#" class="btn btn-sm btn-outline-dark">Add Document</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>File</th>
                            <th>Uploaded At</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($project->documents as $doc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doc->title ?? '-' }}</td>
                            <td>
                                @if($doc->file)
                                    <a href="{{ asset('storage/'.$doc->file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $doc->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No documents uploaded</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- ================= FINANCE TAB ================= --}}
    @if($tab === 'finance')
        @php
            $budget = $project->budget ?? 0;
            $additionalBilled = $project->billings->sum('amount_billed');
            $totalBilled = $budget + $additionalBilled;
            $totalPaid = $project->billings->sum('amount_paid') ?? 0;
            $totalRemaining = $totalBilled - $totalPaid;

            $projectsBillings = $project->billings->map(function($b) {
                return [
                    'amount_billed' => $b->amount_billed,
                    'amount_paid'   => $b->amount_paid ?? 0,
                    'remaining'     => ($b->amount_billed ?? 0) - ($b->amount_paid ?? 0),
                    'status'        => $b->status,
                    'payment_date'  => $b->payment_date,
                    'notes'         => $b->notes,
                    'invoice'       => $b->invoice,
                ];
            })->toArray();
        @endphp

        @include('admin.projects.finance_summary')
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
</style>
@endsection