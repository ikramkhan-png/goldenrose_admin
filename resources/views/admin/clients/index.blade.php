@extends('admin.layouts.app')

@section('content')
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <div class="container" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <x-page-header :title="__('clients.clients')" :description="__('clients.clients_description')" />

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
