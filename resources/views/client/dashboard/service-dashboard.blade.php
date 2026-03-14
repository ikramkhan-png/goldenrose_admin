@extends('admin.layouts.app2')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('client.service_dashboard_title') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('client.service_dashboard_subtitle') }}</p>
        </div>

        <!-- Month Filter -->
        <div class="mb-6">
            <form method="GET" class="flex gap-4 items-center">
                <label for="month" class="text-sm font-medium text-gray-700">{{ __('client.filter_by_month') }}</label>
                <input 
                    type="month" 
                    name="month" 
                    id="month"
                    value="{{ $month }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ __('client.filter') }}
                </button>
            </form>
        </div>

        <!-- Finance Overview -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('client.finance_overview') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <p class="text-gray-600 text-sm">{{ __('client.total_billing') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        PKR {{ number_format($totalBilling, 2) }}
                    </p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                    <p class="text-gray-600 text-sm">{{ __('client.services_count') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $services->count() }}</p>
                </div>
                <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                    <p class="text-gray-600 text-sm">{{ __('admin.billing_records') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ collect($servicesBillings)->sum(fn($s) => $s['count']) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Services List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">{{ __('client.services_details') }}</h2>
            </div>

            @forelse($servicesBillings as $serviceId => $data)
                <div class="border-b border-gray-200 last:border-b-0">
                    <div class="px-6 py-4">
                        <!-- Service Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $data['service']->service->name ?? __('client.service') }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    {{ $data['service']->description ?? __('client.no_description') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">
                                    PKR {{ number_format($data['total'], 2) }}
                                </p>
                                <p class="text-gray-600 text-sm">{{ $data['count'] }} {{ __('client.billing_records') }}</p>
                            </div>
                        </div>

                        <!-- Service Details Table -->
                        @if($data['billings']->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">{{ __('client.date') }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">{{ __('client.rate') }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">{{ __('client.days') }}</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-700 uppercase">{{ __('client.amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($data['billings'] as $billing)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    {{ $billing->billing_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    PKR {{ number_format($billing->rate ?? 0, 2) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    {{ $billing->days ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">
                                                    PKR {{ number_format($billing->amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600 text-sm italic">{{ __('client.no_billing_records_service') }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-8">
                    <p class="text-gray-600 text-center">{{ __('client.no_services_found') }}</p>
                </div>
            @endforelse
        </div>

        <!-- Support Section -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6 border border-blue-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('client.have_questions') }}</h2>
            <p class="text-gray-700 mb-4">
                {{ __('client.contact_services_assistance') }}
            </p>
            <div class="flex gap-4">
                <a href="mailto:support@goldenrose.com" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ __('client.email_us') }}
                </a>
                <button type="button" onclick="alert('{{ __('client.message_system_coming_soon') }}')" class="px-4 py-2 bg-white border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50">
                    {{ __('client.send_message') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
