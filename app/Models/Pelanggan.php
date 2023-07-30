<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $guarded = ['id'];

    public function fotoKtp(): Attribute
    {
        return Attribute::get(
            fn (?string $value) => $value != null ? "storage/$value" : null
        );
    }
}
