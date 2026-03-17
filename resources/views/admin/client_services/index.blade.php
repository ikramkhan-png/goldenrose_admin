@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('clients.client_services') }}</h4>
            <p class="page-subtitle">{{ __('clients.client_services_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.client-services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>{{ __('clients.assign_service') }}
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 mb-4" style="background: #f0fdf4; color: #166534; border-left: 4px solid #22c55e; border-radius: 8px;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-styled mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('clients.client') }}</th>
                            <th>{{ __('clients.service') }}</th>
                            <th>{{ __('admin.rate_type') }}</th>
                            <th>{{ __('admin.duration') }}</th>
                            <th>{{ __('admin.rate') }}</th>
                            <th>{{ __('clients.assigned_date') }}</th>
                            <th>{{ __('admin.total_amount') }}</th>
                            <th class="td-center">{{ __('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientServices as $service)
                            @php
                                if($service->hours > 0) {
                                    $rateType = __('admin.hourly');
                                    $duration  = $service->hours;
                                    $rate      = number_format($service->hourly_rate, 2);
                                } elseif($service->days > 0) {
                                    $rateType = __('admin.daily');
                                    $duration  = $service->days;
                                    $rate      = number_format($service->daily_rate, 2);
                                } else {
                                    $rateType = __('admin.monthly');
                                    $duration  = $service->months;
                                    $rate      = number_format($service->monthly_rate, 2);
                                }
                            @endphp
                            <tr>
                                <td class="td-muted">{{ $loop->iteration }}</td>
                                <td class="td-name">{{ $service->client->name ?? '-' }}</td>
                                <td class="td-accent">{{ $service->service->name ?? '-' }}</td>
                                <td>
                                    <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                                        {{ $rateType }}
                                    </span>
                                </td>
                                <td class="td-muted">{{ $duration }}</td>
                                <td class="td-pos">{{ $rate }}</td>
                                <td class="td-muted">{{ $service->assigned_date ?? '-' }}</td>
                                <td class="td-pos" style="font-weight: 700;">
                                    @if($service->hours > 0)
                                        {{ number_format($service->hours * $service->hourly_rate, 2) }}
                                    @elseif($service->days > 0)
                                        {{ number_format($service->days * $service->daily_rate, 2) }}
                                    @else
                                        {{ number_format($service->months * $service->monthly_rate, 2) }}
                                    @endif
                                </td>
                                <td class="td-center">
                                    <a href="{{ route('admin.client-services.edit', $service) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>{{ __('admin.edit') }}
                                    </a>
                                    <form action="{{ route('admin.client-services.destroy', $service) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash me-1"></i>{{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 td-muted">
                                    <i class="fas fa-inbox" style="font-size: 28px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                                    {{ __('clients.no_services') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
