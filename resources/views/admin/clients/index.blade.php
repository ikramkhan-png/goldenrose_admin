@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <x-page-header :title="__('clients.clients')" :description="__('clients.clients_description')" />

        {{-- MONTH FILTER --}}
        <div class="card border-0 mb-4" style="background: white; border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-4">
                <form action="{{ route('admin.clients.index') }}" method="GET" class="d-flex align-items-end gap-4 flex-wrap">
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

        <div class="d-flex justify-content-between mb-3">
            <h4>{{ __('clients.clients') }}</h4>
            <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
                + {{ __('clients.add_client') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('clients.name') }}</th>
                    <th>{{ __('clients.email') }}</th>
                    <th>{{ __('clients.phone') }}</th>
                    <th>{{ __('clients.client_type') }}</th>
                    <th>{{ __('admin.created_date') }}</th>
                    <th width="180">{{ __('clients.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone ?? '-' }}</td>
                        <td>{{ ucfirst($client->client_type ?? '-') }}</td>
                        <td>{{ $client->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.clients.show', $client) }}"
                                class="btn btn-sm btn-info">{{ __('clients.view') }}</a>
                            <a href="{{ route('admin.clients.edit', $client) }}"
                                class="btn btn-sm btn-warning">{{ __('clients.edit') }}</a>
                            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST"
                                class="d-inline-block" onsubmit="return confirm('{{ __('clients.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">{{ __('clients.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('clients.no_clients') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
