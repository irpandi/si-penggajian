<?php

// * Author By : Rifki Irpandi

namespace App\Http\Service;

use Carbon\Carbon;

class General
{
    // * Manage Date conversion to specific format
    public static function manageDate($fromFormat, $date, $toFormat)
    {
        if ($date) {
            $data = Carbon::createFromFormat($fromFormat, $date)
                ->format($toFormat);

            return $data;
        }
    }

    // * For formatter numbering
    public static function formaterNumber($angka, $berapaNol)
    {
        return 'Rp. ' . number_format($angka, $berapaNol, ',', '.');
    }
}
