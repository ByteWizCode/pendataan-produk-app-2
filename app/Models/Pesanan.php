<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $guarded = ['id'];

    protected $fillable = [
        'pelanggan_id',
        'status',
        'produk_id',
        'harga',
        'jumlah',
        'total',
        'staff_id',
        'submitted_at',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(produk::class, 'produk_id');
    }
}
