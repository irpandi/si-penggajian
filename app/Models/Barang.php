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

    public function periode()
    {
        return $this->hasOne(Periode::class, 'id', 'periode_id');
    }

    // * Method function for replicate item
    public function replicateItem()
    {
        $clone = $this->replicate()->fill([
            'nama' => $this->nama . '-copy',
        ]);
        $clone->push();

        foreach ($this->item as $value) {
            $clone->item()->create([
                'nama'             => $value->nama,
                'harga'            => $value->harga,
                'total_tmp_barang' => $this->total,
            ]);
        }

        $clone->save();
    }
}
