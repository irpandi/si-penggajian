<?php

namespace App\Models;

use App\Http\Service\General;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table   = 'tbl_periode';
    protected $guarded = ['id'];

    public static function changeTglPeriodeForValidation($req)
    {
        $tglPeriode    = $req->tglPeriode;
        $newTglPeriode = General::manageDate('d/m/Y', $tglPeriode, 'Y-m-d');

        return $newTglPeriode;
    }
}
