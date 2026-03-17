@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4 py-3">

        {{-- ===== HEADER ===== --}}
        <div class="client-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 fw-semibold text-white">{{ __('client_services.service_details') }}</h3>
                    <small class="text-white-50">{{ __('client_services.view_assigned_service_information') }}</small>
                </div>
                <a href="{{ route('admin.clients.show', $clientService->client_id) }}" class="btn btn-light btn-sm">
                    ← {{ __('common.back_to_client') }}
                </a>
            </div>
        </div>

        {{-- ===== SERVICE INFO CARD ===== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">{{ __('client_services.service_information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">{{ __('clients.client') }}:</th>
                                <td>{{ $clientService->client->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('client_services.service_type') }}:</th>
                                <td>{{ class_basename($clientService->service_type ?? '') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('client_services.service_name') }}:</th>
                                <td>{{ $clientService->service->name ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%;">{{ __('client_services.rate_type') }}:</th>
                                <td>
                                    @if ($clientService->hourly_rate > 0)
                                        {{ __('client_services.hourly') }}
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
                                <th>{{ __('client_services.duration') }}:</th>
                                <td>
                                    @if ($clientService->hours > 0)
                                        {{ $clientService->hours }} {{ __('client_services.hours') }}
                                    @elseif($clientService->days > 0)
                                        {{ $clientService->days }} {{ __('client_services.days') }}
                                    @elseif($clientService->months > 0)
                                        {{ $clientService->months }} {{ __('client_services.months') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('client_services.rate') }}:</th>
                                <td class="fw-bold text-primary">
                                    @if ($clientService->hourly_rate > 0)
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
                <div class="card p-4"
                    style="background: #f5f3ff; border: 1px solid #c7d2fe;">
                    <h6 class="fw-bold mb-2" style="color: #4f46e5; font-size: 12px; text-transform: uppercase; letter-spacing: 0.6px;">Total Cost</h6>
                    <h3 class="fw-bold mb-0" style="color: #1e293b;">
                        @php
                            $totalCost = 0;
                            if ($clientService->hourly_rate > 0) {
                                $totalCost = $clientService->hours * $clientService->hourly_rate;
                            } elseif ($clientService->daily_rate > 0) {
                                $totalCost = $clientService->days * $clientService->daily_rate;
                            } elseif ($clientService->monthly_rate > 0) {
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
            <form action="{{ route('admin.client-services.destroy', $clientService->id) }}" method="POST"
                class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this service?')">
                    <i class="fas fa-trash"></i> Delete Service
                </button>
            </form>
        </div>

    </div>

    {{-- ===== STYLE BLOCK ===== --}}
    <style>
        .client-header {
            background: #1a2535;
            border-radius: 12px;
            padding: 20px 24px;
        }
    </style>
@endsection
