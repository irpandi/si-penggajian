<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TotalGaji extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $table   = 'tbl_total_gaji';
    protected $guarded = ['id'];

    public function tunjangan()
    {
        return $this->hasMany(Tunjangan::class, 'total_gaji_id', 'id');
    }

    public function periode()
    {
        return $this->hasOne(Periode::class, 'id', 'periode_id');
    }
}
