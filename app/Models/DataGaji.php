<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataGaji extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $table   = 'tbl_data_gaji';
    protected $guarded = ['id'];

    public function subItem()
    {
        return $this->hasOne(SubItem::class, 'id', 'sub_item_id');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id', 'karyawan_id');
    }
}
