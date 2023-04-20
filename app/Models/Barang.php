<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table   = 'tbl_barang';
    protected $guarded = ['id'];

    public function item()
    {
        return $this->hasMany(Item::class, 'barang_id', 'id');
    }
}
