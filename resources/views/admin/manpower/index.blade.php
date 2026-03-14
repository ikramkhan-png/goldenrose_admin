@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('manpower.manpower_list') }}</h1>
        
        {{-- MONTH FILTER --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.manpower.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
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

        <a href="{{ route('admin.manpower.create') }}" class="btn btn-primary mb-3">
            {{ __('manpower.add_manpower') }}
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('manpower.id') }}</th>
                    <th>{{ __('manpower.name') }}</th>
                    <th>{{ __('manpower.hourly_rate') }}</th>
                    <th>{{ __('manpower.daily_rate') }}</th>
                    <th>{{ __('manpower.monthly_rate') }}</th>
                    <th>{{ __('manpower.status') }}</th>
                    <th>{{ __('admin.created_date') }}</th>
                    <th>{{ __('manpower.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($manpowers as $manpower)
                    <tr>
                        <td>{{ $manpower->id }}</td>
                        <td>{{ $manpower->name }}</td>
                        <td>{{ $manpower->hourly_rate }}</td>
                        <td>{{ $manpower->daily_rate }}</td>
                        <td>{{ $manpower->monthly_rate }}</td>
                        <td>
                            @if ($manpower->status === 'active')
                                {{ __('manpower.status_active') }}
                            @else
                                {{ __('manpower.status_inactive') }}
                            @endif
                        </td>
                        <td>{{ $manpower->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.manpower.edit', $manpower->id) }}"
                                class="btn btn-sm btn-warning">{{ __('manpower.edit') }}</a>
                            <form action="{{ route('admin.manpower.destroy', $manpower->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('{{ __('manpower.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">{{ __('manpower.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">{{ __('manpower.no_manpower') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
