<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $table   = 'tbl_karyawan';
    protected $guarded = ['id'];
}
