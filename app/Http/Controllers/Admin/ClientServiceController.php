<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientService;
use App\Models\User;
use App\Models\ClientServiceBilling;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'amount_paid'  => $validated['amount_paid'],
            'payment_date' => $validated['payment_date'],
            'status'       => $validated['status'],
            'invoice'      => $invoicePath,
            'notes'        => $validated['notes'],
            'client_service_id' => $firstServiceId,
        ]);

        return redirect()
            ->route('admin.clients.show', $clientId)
            ->with('success', 'Client billing created successfully');
    }

    // ========================
    // ASSIGN SERVICE TO CLIENT
    // ========================
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);
        
        // Filter client services by month based on assigned_date
        $clientServices = ClientService::with(['client','service'])
            ->whereYear('assigned_date', $selectedMonth->year)
            ->whereMonth('assigned_date', $selectedMonth->month)
            ->latest('assigned_date')
            ->get();
            
        return view('admin.client_services.index', compact('clientServices', 'selectedMonth'));
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
            'assigned_date' => 'required|date',
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
            'assigned_date' => $request->assigned_date,
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
            'assigned_date' => 'required|date',
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
            'assigned_date' => $request->assigned_date,
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
    public function financeSummary($clientId, Request $request)
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

        // Get all billings with month filtering
        $allBillingsQuery = $client->services->flatMap(fn ($s) => $s->billings);

        // Filter by payment date month if provided
        if ($request->filled('month')) {
            $month = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
            $allBillingsQuery = $allBillingsQuery->filter(function ($billing) use ($month) {
                if ($billing->payment_date) {
                    $paymentDate = \Carbon\Carbon::parse($billing->payment_date);
                    return $paymentDate->year == $month->year && $paymentDate->month == $month->month;
                }
                return false;
            });
        }

        $allBillings = $allBillingsQuery->map(fn ($b) => [
            'id'           => $b->id,
            'amount_paid'  => $b->amount_paid,
            'payment_date' => $b->payment_date,
            'status'       => $b->status,
            'notes'        => $b->notes,
            'invoice'      => $b->invoice ? Storage::url($b->invoice) : null,
        ]);

        $totalPaid = $allBillings->sum('amount_paid');
        $totalRemaining = $totalServiceAmount - $totalPaid;

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