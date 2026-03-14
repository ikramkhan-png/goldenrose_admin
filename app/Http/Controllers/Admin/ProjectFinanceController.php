<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectFinanceController extends Controller
{
    public function summary(Project $project, Request $request)
    {
        $query = $project->billings();

        // Filter by payment date month
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('payment_date', $month->year)
                  ->whereMonth('payment_date', $month->month);
        }

        $billings = $query->latest()->get();

        $totalBilled = $billings->sum('amount_billed');
        $totalPaid   = $billings->sum('amount_paid');
        $totalRemaining = $totalBilled - $totalPaid;

        return view('admin.projects.finance_summary', compact(
            'project',
            'billings',
            'totalBilled',
            'totalPaid',
            'totalRemaining'
        ));
    }
}