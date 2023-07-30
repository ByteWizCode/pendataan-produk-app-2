<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $guarded = ['id'];

    public function gambar(): Attribute
    {
        return Attribute::get(
            fn (?string $value) => $value == null ? 'assets/images/default-product.jpg' : "storage/$value"
        );
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisProduk::class, 'jenis_produk_id');
    }
}
