@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">

    {{-- ===== HEADER ===== --}}
    <div class="client-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-semibold text-white">Service Details</h3>
                <small class="text-white-50">View assigned service information</small>
            </div>
            <a href="{{ route('admin.clients.show', $clientService->client_id) }}" class="btn btn-light btn-sm">
                ← Back to Client
            </a>
        </div>
    </div>

    {{-- ===== SERVICE INFO CARD ===== --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0 fw-semibold">Service Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%;">Client:</th>
                            <td>{{ $clientService->client->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Service Type:</th>
                            <td>{{ class_basename($clientService->service_type ?? '') }}</td>
                        </tr>
                        <tr>
                            <th>Service Name:</th>
                            <td>{{ $clientService->service->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%;">Rate Type:</th>
                            <td>
                                @if($clientService->hourly_rate > 0)
                                    Hourly
                                @elseif($clientService->daily_rate > 0)
                                    Daily
                                @elseif($clientService->monthly_rate > 0)
                                    Monthly
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Duration:</th>
                            <td>
                                @if($clientService->hours > 0)
                                    {{ $clientService->hours }} hours
                                @elseif($clientService->days > 0)
                                    {{ $clientService->days }} days
                                @elseif($clientService->months > 0)
                                    {{ $clientService->months }} months
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Rate:</th>
                            <td class="fw-bold text-primary">
                                @if($clientService->hourly_rate > 0)
                                    {{ number_format($clientService->hourly_rate, 2) }} /hr
                                @elseif($clientService->daily_rate > 0)
                                    {{ number_format($clientService->daily_rate, 2) }} /day
                                @elseif($clientService->monthly_rate > 0)
                                    {{ number_format($clientService->monthly_rate, 2) }} /month
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TOTAL COST CARD ===== --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h6 class="fw-bold mb-2">💰 Total Cost</h6>
                <h3 class="fw-bold mb-0">
                    @php
                        $totalCost = 0;
                        if($clientService->hourly_rate > 0) {
                            $totalCost = $clientService->hours * $clientService->hourly_rate;
                        } elseif($clientService->daily_rate > 0) {
                            $totalCost = $clientService->days * $clientService->daily_rate;
                        } elseif($clientService->monthly_rate > 0) {
                            $totalCost = $clientService->months * $clientService->monthly_rate;
                        }
                    @endphp
                    {{ number_format($totalCost, 2) }}
                </h3>
            </div>
        </div>
    </div>

    {{-- ===== ACTIONS ===== --}}
    <div class="mt-4">
        <a href="{{ route('admin.client-services.edit', $clientService->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit Service
        </a>
        <form action="{{ route('admin.client-services.destroy', $clientService->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">
                <i class="fas fa-trash"></i> Delete Service
            </button>
        </form>
    </div>

</div>

{{-- ===== STYLE BLOCK ===== --}}
<style>
.client-header {
    background: linear-gradient(135deg, #1f2937, #374151);
    border-radius: 14px;
    padding: 22px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
</style>
@endsection
