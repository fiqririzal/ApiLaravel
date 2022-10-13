<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $fillable = [
        'nama_item', 'harga', 'stok', 'keterangan','created_at', 'updated_at'
    ];
    public function GaleriProduk() {
        return $this->belongsTo(GaleriProduk::class, 'id');
    }
}
