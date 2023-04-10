<?php

namespace App\Http\Service;

use Carbon\Carbon;

class General
{
    public static function manageDate($fromFormat, $date, $toFormat)
    {
        $data = Carbon::createFromFormat($fromFormat, $date)
            ->format($toFormat);

        return $data;
    }
}
