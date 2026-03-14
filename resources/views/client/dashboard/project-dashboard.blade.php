@extends('admin.layouts.app2')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('client.project_dashboard_title') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('client.project_dashboard_subtitle') }}</p>
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
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('client.overall_finance_information') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <p class="text-gray-600 text-sm">{{ __('client.total_budget') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        PKR {{ number_format($totalBudget, 2) }}
                    </p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                    <p class="text-gray-600 text-sm">{{ __('client.total_paid') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        PKR {{ number_format($totalPaid, 2) }}
                    </p>
                </div>
                <div class="bg-orange-50 p-6 rounded-lg border border-orange-200">
                    <p class="text-gray-600 text-sm">{{ __('client.total_remaining') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        PKR {{ number_format($totalRemaining, 2) }}
                    </p>
                </div>
                <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
                    <p class="text-gray-600 text-sm">{{ __('client.active_projects') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $projects->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Projects List -->
        <div class="space-y-6">
            @forelse($projectsData as $projectId => $data)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Project Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    {{ $data['project']->name }}
                                </h3>
                                <p class="text-blue-100 text-sm mt-1">
                                    {{ $data['project']->description ?? __('client.no_description') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Project Content -->
                    <div class="px-6 py-6">
                        <!-- Finance Details -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('client.finance_details') }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-gray-600 text-sm">{{ __('client.budget') }}</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        PKR {{ number_format($data['budget'], 2) }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-gray-600 text-sm">{{ __('client.paid') }}</p>
                                    <p class="text-2xl font-bold text-green-600">
                                        PKR {{ number_format($data['paid'], 2) }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-gray-600 text-sm">{{ __('client.remaining') }}</p>
                                    <p class="text-2xl font-bold text-orange-600">
                                        PKR {{ number_format($data['remaining'], 2) }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <p class="text-gray-600 text-sm">{{ __('client.progress') }}</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        {{ $data['budget'] > 0 ? round(($data['paid'] / $data['budget']) * 100, 1) : 0 }}%
                                    </p>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div 
                                        class="bg-blue-600 h-2 rounded-full"
                                        style="width: {{ $data['budget'] > 0 ? ($data['paid'] / $data['budget']) * 100 : 0 }}%"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Billing Information -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('client.billing_information') }} ({{ $month }})</h4>
                            @if($data['billings']->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">{{ __('client.date') }}</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">{{ __('client.description') }}</th>
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
                                                        {{ $billing->description ?? '-' }}
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
                                <p class="text-gray-600 text-sm italic">{{ __('client.no_billing_records_month') }}</p>
                            @endif
                        </div>

                        <!-- Documents -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ __('client.project_documents_updates') }}</h4>
                            @if($data['documents']->count() > 0)
                                <div class="space-y-3">
                                    @foreach($data['documents'] as $doc)
                                        <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            <div class="flex-shrink-0">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $doc->title ?? __('client.document') }}
                                                </p>
                                                <p class="text-xs text-gray-600 mt-1">
                                                    {{ $doc->description ?? __('client.no_description') }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-2">
                                                    {{ __('client.uploaded_on') }} {{ $doc->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <a href="{{ $doc->file_path ?? '#' }}" class="ml-4 px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                                {{ __('client.view') }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600 text-sm italic">{{ __('client.no_documents_uploaded') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-8">
                    <p class="text-gray-600 text-center">{{ __('client.no_projects_found') }}</p>
                </div>
            @endforelse
        </div>

        <!-- Support Section -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6 border border-blue-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('client.have_questions') }}</h2>
            <p class="text-gray-700 mb-4">
                {{ __('client.contact_assistance') }}
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
