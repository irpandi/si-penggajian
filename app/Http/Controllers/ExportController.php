<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use PDF;

class ExportController extends Controller
{
    // * Method for export penggajian karyawan
    public function exportPenggajian($karyawanId, $periodeId)
    {
        $karyawan = Karyawan::where('id', $karyawanId)
            ->with('totalGaji', function ($q) use ($periodeId) {
                $q->with('periode', function ($subQ) use ($periodeId) {
                    $subQ->where('id', $periodeId);
                })
                    ->with('tunjangan');
            })
            ->with('dataGaji', function ($q) {
                $q->with('subItem', function ($subQ) {
                    $subQ->with('item', function ($query) {
                        $query->with('barang');
                    });
                });
            })
            ->first();

        $pdf = PDF::loadView('export.penggajian', [
            'karyawan' => $karyawan,
        ])
            ->setOptions([
                'defaultFont' => 'sans-serif',
            ]);

        return $pdf->download($karyawan->nama . '-gaji' . '.pdf');
    }
}
