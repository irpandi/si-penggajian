<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGaji extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table   = 'tbl_data_gaji';
    protected $guarded = ['id'];

    public function tunjangan()
    {
        return $this->hasMany(Tunjangan::class, 'data_gaji_id', 'id');
    }

    public function subItem()
    {
        return $this->hasOne(SubItem::class, 'id', 'sub_item_id');
    }
}
