<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = Contract::with('customer', 'rental.piano');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contracts = $query->latest()->paginate(15);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function show(Contract $contract)
    {
        $contract->load('customer', 'rental.piano');
        return view('admin.contracts.show', compact('contract'));
    }

    public function downloadPdf(Contract $contract, ContractService $contractService)
    {
        if (!$contract->pdf_path || !Storage::disk('local')->exists($contract->pdf_path)) {
            $contractService->generatePdf($contract);
        }

        return Storage::disk('local')->download($contract->pdf_path, $contract->contract_number . '.pdf');
    }
}
