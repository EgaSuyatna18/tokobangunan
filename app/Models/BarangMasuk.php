<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $guarded = [];

    public function barang()
    {
        return $this->BelongsTo(Barang::class);
    }

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function supplier()
    {
        return $this->BelongsTo(Supplier::class);
    }
}