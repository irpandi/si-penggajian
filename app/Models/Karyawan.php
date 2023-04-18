<?php

namespace App\Models;

use App\Http\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;
    protected $table   = 'tbl_karyawan';
    protected $guarded = ['id'];
}
