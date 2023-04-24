<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table   = 'tbl_transaksi_item';
    protected $guarded = ['id'];
}
