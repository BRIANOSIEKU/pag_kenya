<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PastoralTransfer;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferLetterController extends Controller
{
    /**
     * Show transfer letter (ADMIN)
     */
    public function show($id)
    {
        $transfer = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'fromAssembly',
            'toDistrict',
            'toAssembly'
        ])->findOrFail($id);

        // 🔐 SECURITY CHECK: only approved transfers can view letter
        if ($transfer->status !== 'approved' || $transfer->main_admin_approved != 1) {
            abort(403, 'Transfer letter is not available until approval.');
        }

        return view('district_admin.pastoral_transfers.letter', compact('transfer'));
    }

    /**
     * Download PDF letter (ADMIN)
     */
    public function download($id)
    {
        $transfer = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'fromAssembly',
            'toDistrict',
            'toAssembly'
        ])->findOrFail($id);

        // 🔐 SECURITY CHECK
        if ($transfer->status !== 'approved' || $transfer->main_admin_approved != 1) {
            abort(403, 'Cannot download letter before approval.');
        }

        $pdf = Pdf::loadView('district_admin.pastoral_transfers.letter', compact('transfer'));

        return $pdf->download('transfer-letter-' . $transfer->id . '.pdf');
    }
}