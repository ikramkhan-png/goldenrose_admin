@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h4>{{ __('client_services.add_billing_for_client') }}: {{ $client->name }}</h4>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please fix the following issues:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.client-services.storeClientBilling', $client->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>{{ __('client_services.amount_received') }}</label>
            <input type="number" step="0.01" name="amount_paid" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>{{ __('client_services.payment_date') }}</label>
            <input type="date" name="payment_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>{{ __('client_services.status') }}</label>
            <select name="status" class="form-control" required>
                <option value="pending">{{ __('common.pending') }}</option>
                <option value="paid">{{ __('common.paid') }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label>{{ __('client_services.invoice_pdf_jpg_png') }}</label>
            <input type="file" name="invoice" class="form-control">
        </div>

        <div class="mb-3">
            <label>{{ __('client_services.notes') }}</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-primary">{{ __('client_services.save_billing') }}</button>
        <a href="{{ route('admin.client-services.financeSummary', $client->id) }}" class="btn btn-secondary">{{ __('common.cancel') }}</a>
    </form>
</div>
@endsection