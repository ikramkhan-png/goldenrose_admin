<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectFinanceController extends Controller
{
    public function summary(Project $project)
    {
        $billings = $project->billings;

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