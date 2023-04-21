<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $table   = 'tbl_item';
    protected $guarded = ['id'];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'barang_id', 'id');
    }

    public function subItem()
    {
        return $this->hasMany(SubItem::class, 'item_id', 'id');
    }
}
