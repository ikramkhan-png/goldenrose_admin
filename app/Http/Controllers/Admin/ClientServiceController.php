<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientService;
use App\Models\User;
use App\Models\ClientServiceBilling;
use Illuminate\Support\Facades\Storage;

class ClientServiceController extends Controller
{
    // ========================
    // CLIENT LEVEL BILLING
    // ========================
    public function createClientBilling($clientId)
    {
        $client = User::with('services')->findOrFail($clientId);
        return view('admin.client_services.add_billing', compact('client'));
    }

    public function storeClientBilling(Request $request, $clientId)
    {
        $client = User::with('services')->findOrFail($clientId);

        $validated = $request->validate([
            'amount_paid'  => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status'       => 'required|in:pending,paid',
            'invoice'      => 'nullable|file|mimes:pdf,jpg,png',
            'notes'        => 'nullable|string|max:500',
        ]);

        // Check if client has services
        if ($client->services->isEmpty()) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Client has no services assigned. Please assign a service first.'])
                ->withInput();
        }

        $invoicePath = null;
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('invoices', 'public');
        }

        $firstServiceId = $client->services->first()->id;

        ClientServiceBilling::create([
            'client_service_id' => $firstServiceId,
            'amount_billed'     => 0,
            'amount_paid'       => $validated['amount_paid'],
            'payment_date'      => $validated['payment_date'],
            'status'            => $validated['status'],
            'invoice'           => $invoicePath,
            'notes'             => $validated['notes'],
        ]);

        return redirect()
            ->route('admin.client-services.financeSummary', $clientId)
            ->with('success', 'Billing added successfully!');
    }

    // ========================
    // ASSIGN SERVICE TO CLIENT
    // ========================
    public function index()
    {
        // Added this to match blade expecting $clientServices
        $clientServices = ClientService::with(['client','service'])->get();
        return view('admin.client_services.index', compact('clientServices'));
    }

    public function create()
    {
        // Fetch clients from users table (fix previous issue)
        $clients     = User::orderBy('name')->get(); 
        $services    = \App\Models\Service::orderBy('name')->get();
        $machineries = \App\Models\Machinery::orderBy('name')->get();
        $manpowers   = \App\Models\Manpower::orderBy('name')->get();

        return view(
            'admin.client_services.create',
            compact('clients', 'services', 'machineries', 'manpowers')
        );
    }

    public function store(Request $request)
    {
        // New store method for assigning service
        $request->validate([
            'client_id'    => 'required|exists:users,id',
            'service_type' => 'required',
            'service_id'   => 'required',
            'rate_type'    => 'required|in:hourly,daily,monthly',
            'duration'     => 'required|numeric|min:1',
            'rate'         => 'required|numeric|min:0',
        ]);

        $data = [
            'client_id'    => $request->client_id,
            'service_type' => $request->service_type,
            'service_id'   => $request->service_id,
            'hours'        => 0,
            'hourly_rate'  => 0,
            'days'         => 0,
            'daily_rate'   => 0,
            'months'       => 0,
            'monthly_rate' => 0,
        ];

        // Map rate_type and duration to specific columns
        if ($request->rate_type === 'hourly') {
            $data['hours'] = $request->duration;
            $data['hourly_rate'] = $request->rate;
        } elseif ($request->rate_type === 'daily') {
            $data['days'] = $request->duration;
            $data['daily_rate'] = $request->rate;
        } else { // monthly
            $data['months'] = $request->duration;
            $data['monthly_rate'] = $request->rate;
        }

        ClientService::create($data);

        // Redirect to client's show page after assigning service
        return redirect()->route('admin.clients.show', $request->client_id)
            ->with('success', 'Service assigned successfully');
    }

    public function edit($id)
    {
        $clientService = ClientService::with('client', 'service')->findOrFail($id);
        $machineries = \App\Models\Machinery::orderBy('name')->get();
        $manpowers   = \App\Models\Manpower::orderBy('name')->get();
        
        return view('admin.client_services.edit', compact('clientService', 'machineries', 'manpowers'));
    }

    public function update(Request $request, $id)
    {
        $clientService = ClientService::findOrFail($id);

        $request->validate([
            'service_type' => 'required',
            'service_id'   => 'required',
            'rate_type'    => 'required|in:hourly,daily,monthly',
            'duration'     => 'required|numeric|min:1',
            'rate'         => 'required|numeric|min:0',
        ]);

        // Map rate_type and duration to specific columns
        // Set unused rate columns to 0 (not null) to avoid database constraint violations
        $data = [
            'service_type' => $request->service_type,
            'service_id'   => $request->service_id,
            'hours'        => 0,
            'hourly_rate'  => 0,
            'days'         => 0,
            'daily_rate'   => 0,
            'months'       => 0,
            'monthly_rate' => 0,
        ];

        // Map rate_type and duration to specific columns
        if ($request->rate_type === 'hourly') {
            $data['hours'] = $request->duration;
            $data['hourly_rate'] = $request->rate;
        } elseif ($request->rate_type === 'daily') {
            $data['days'] = $request->duration;
            $data['daily_rate'] = $request->rate;
        } else { // monthly
            $data['months'] = $request->duration;
            $data['monthly_rate'] = $request->rate;
        }

        $clientService->update($data);

        return redirect()->route('admin.clients.show', $clientService->client_id)
            ->with('success', 'Service updated successfully');
    }

    public function destroy($id)
    {
        $clientService = ClientService::findOrFail($id);
        $clientId = $clientService->client_id;
        $clientService->delete();

        return redirect()->route('admin.clients.show', $clientId)
            ->with('success', 'Service deleted successfully');
    }

    public function view($id)
    {
        $clientService = ClientService::with('client', 'service')->findOrFail($id);
        return view('admin.client_services.view', compact('clientService'));
    }

    // ========================
    // FINANCE SUMMARY
    // ========================
    public function financeSummary($clientId)
    {
        $client = User::with(['services', 'services.billings'])->findOrFail($clientId);

        // Calculate total service amount (rate × duration for each service)
        $totalServiceAmount = $client->services->sum(function ($svc) {
            if ($svc->hours > 0) {
                return $svc->hours * $svc->hourly_rate;
            } elseif ($svc->days > 0) {
                return $svc->days * $svc->daily_rate;
            } else {
                return $svc->months * $svc->monthly_rate;
            }
        });
        $totalPaid = $client->services
            ->flatMap(fn ($s) => $s->billings)
            ->sum('amount_paid');

        $totalRemaining = $totalServiceAmount - $totalPaid;

        $allBillings = $client->services->flatMap(
            fn ($s) => $s->billings->map(fn ($b) => [
                'id'           => $b->id,
                'amount_paid'  => $b->amount_paid,
                'payment_date' => $b->payment_date,
                'status'       => $b->status,
                'notes'        => $b->notes,
                'invoice'      => $b->invoice ? Storage::url($b->invoice) : null,
            ])
        );

        return view(
            'admin.client_services.finance_summary',
            compact(
                'client',
                'allBillings',
                'totalServiceAmount',
                'totalPaid',
                'totalRemaining'
            )
        );
    }

    // ========================
    // EDIT BILLING
    // ========================
    public function editBilling($id)
    {
        $billing = ClientServiceBilling::with('clientService.service')->findOrFail($id);
        return view('admin.client_services.edit_billing', compact('billing'));
    }

    // ========================
    // UPDATE BILLING
    // ========================
    public function updateBilling(Request $request, $id)
    {
        $billing = ClientServiceBilling::findOrFail($id);

        $request->validate([
            'amount_paid'  => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'status'       => 'required|in:pending,paid',
            'invoice'      => 'nullable|file|mimes:pdf,jpg,png',
            'notes'        => 'nullable|string|max:500',
        ]);

        $invoicePath = $billing->invoice;
        if ($request->hasFile('invoice')) {
            $invoicePath = $request->file('invoice')->store('invoices', 'public');
        }

        $billing->update([
            'amount_paid'  => $request->amount_paid,
            'payment_date' => $request->payment_date,
            'status'       => $request->status,
            'invoice'      => $invoicePath,
            'notes'        => $request->notes,
        ]);

        return redirect()
            ->route('admin.client-services.financeSummary', $billing->clientService->client_id)
            ->with('success', 'Billing updated successfully');
    }

    // ========================
    // DELETE BILLING
    // ========================
    public function deleteBilling($id)
    {
        ClientServiceBilling::findOrFail($id)->delete();
        return back()->with('success', 'Billing deleted successfully');
    }
}