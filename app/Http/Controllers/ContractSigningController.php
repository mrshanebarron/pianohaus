<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Http\Request;

class ContractSigningController extends Controller
{
    public function __construct(
        private ContractService $contractService
    ) {}

    public function show(Contract $contract)
    {
        if ($contract->status === 'signed') {
            return redirect()->route('portal.dashboard')
                ->with('success', 'This contract has already been signed.');
        }

        $contract->load(['rental.piano.brand', 'customer']);

        if (!$contract->viewed_at) {
            $contract->update(['viewed_at' => now(), 'status' => 'viewed']);
        }

        return view('storefront.contract-sign', compact('contract'));
    }

    public function store(Request $request, Contract $contract)
    {
        if ($contract->status === 'signed') {
            return back()->with('error', 'This contract has already been signed.');
        }

        $validated = $request->validate([
            'signature' => 'required|string',
        ]);

        $this->contractService->recordSignature(
            $contract,
            $validated['signature'],
            $request->ip()
        );

        return redirect()->route('portal.dashboard')
            ->with('success', 'Contract signed successfully! Your rental agreement is now active.');
    }
}
