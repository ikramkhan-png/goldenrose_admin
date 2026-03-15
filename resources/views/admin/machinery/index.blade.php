@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h1 class="mb-4">{{ __('machinery.machinery_list') }}</h1>
        
        {{-- MONTH FILTER --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.machinery.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
                    <div style="flex: 1; min-width: 250px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📅 {{ __('admin.filter_by_month') }}</label>
                        <input type="month" name="month" class="form-control" value="{{ request('month', now()->format('Y-m')) }}"
                               onchange="this.form.submit()" style="padding: 12px 14px; border: 2px solid #e8ecf1; border-radius: 8px; font-weight: 500; background: #f8f9fc; font-size: 14px;">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">📆 {{ __('admin.filter') }}</label>
                        <div style="padding: 12px 14px; border: 2px solid #667eea; border-radius: 8px; background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); font-weight: 600; color: #667eea; font-size: 14px;">
                            {{ request('month') ? \Carbon\Carbon::createFromFormat('Y-m', request('month'))->format('F Y') : __('All Data') }}
                        </div>
                    </div>
                    @if(request('month'))
                    <div style="min-width: 120px;">
                        <label class="form-label fw-bold" style="color: #2c3e50; font-size: 13px; text-transform: uppercase; letter-spacing: 1px;">&nbsp;</label>
                        <a href="{{ route('admin.machinery.index') }}" class="btn btn-outline-secondary w-100" style="padding: 12px 14px; border: 2px solid #6c757d; border-radius: 8px; font-weight: 500; font-size: 14px;">
                            <i class="fas fa-times"></i> {{ __('Show All') }}
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <a href="{{ route('admin.machinery.create') }}" class="btn btn-primary mb-3">
            {{ __('machinery.add_machinery') }}
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('machinery.id') }}</th>
                    <th>{{ __('machinery.name') }}</th>
                    <th>{{ __('machinery.model') }}</th>
                    <th>{{ __('machinery.number_plate') }}</th>
                    <th>{{ __('machinery.hourly_rate') }}</th>
                    <th>{{ __('machinery.daily_rate') }}</th>
                    <th>{{ __('machinery.monthly_rate') }}</th>
                    <th>{{ __('machinery.status') }}</th>
                    <th>{{ __('admin.created_date') }}</th>
                    <th>{{ __('machinery.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($machineries as $machinery)
                    <tr>
                        <td>{{ $machinery->id }}</td>
                        <td>{{ $machinery->name }}</td>
                        <td>{{ $machinery->model ?? '-' }}</td>
                        <td>{{ $machinery->number_plate ?? '-' }}</td>
                        <td>{{ $machinery->hourly_rate }}</td>
                        <td>{{ $machinery->daily_rate }}</td>
                        <td>{{ $machinery->monthly_rate }}</td>
                        <td>
                            @if ($machinery->status === 'active')
                                {{ __('machinery.status_active') }}
                            @else
                                {{ __('machinery.status_inactive') }}
                            @endif
                        </td>
                        <td>{{ $machinery->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.machinery.edit', $machinery->id) }}"
                                class="btn btn-sm btn-warning">{{ __('machinery.edit') }}</a>
                            <form action="{{ route('admin.machinery.destroy', $machinery->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('{{ __('machinery.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">{{ __('machinery.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">{{ __('machinery.no_machinery') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
