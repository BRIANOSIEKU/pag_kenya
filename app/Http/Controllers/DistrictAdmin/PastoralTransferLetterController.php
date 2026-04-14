<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use App\Models\PastoralTransfer;
use Barryvdh\DomPDF\Facade\Pdf;

class PastoralTransferLetterController extends Controller
{
    public function download($id)
    {
        $transfer = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ])->findOrFail($id);

        // CHECK APPROVAL STATUS
        $isSameDistrict = $transfer->from_district_id == $transfer->to_district_id;

        $isApproved = (
            ($isSameDistrict && $transfer->status === 'approved')
            ||
            (!$isSameDistrict && $transfer->to_district_approved && $transfer->status === 'approved')
        );

        if (!$isApproved) {
            return redirect()->back()->with('error', 'Transfer not fully approved for letter generation.');
        }

        $pdf = Pdf::loadView('district_admin.pastoral_transfers.letter', [
            'transfer' => $transfer
        ]);

        return $pdf->download(
            'pastoral-transfer-letter-' . $transfer->id . '.pdf'
        );
    }
}