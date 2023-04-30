<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tunjangan extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table   = ['tbl_tunjangan'];
    protected $guarded = ['id'];
}
