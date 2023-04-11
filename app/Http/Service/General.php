<?php

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
}
