@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ __('departments.departments') }}</h2>
        
        {{-- MONTH FILTER --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.departments.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
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

        <a href="{{ route('admin.departments.create') }}" class="btn btn-success mb-2">
            {{ __('departments.add_department') }}
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th>{{ __('departments.name') }}</th>
                <th>{{ __('departments.description') }}</th>
                <th>{{ __('admin.created_date') }}</th>
                <th>{{ __('departments.actions') }}</th>
            </tr>
            @foreach ($departments as $dep)
                <tr>
                    <td>{{ $dep->name }}</td>
                    <td>{{ $dep->description }}</td>
                    <td>{{ $dep->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.departments.edit', $dep->id) }}"
                            class="btn btn-primary btn-sm">{{ __('departments.edit') }}</a>
                        <form action="{{ route('admin.departments.destroy', $dep->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('{{ __('departments.confirm_delete') }}')">
                                {{ __('departments.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
