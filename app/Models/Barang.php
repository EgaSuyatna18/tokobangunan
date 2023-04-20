<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $guarded = [];

    public function satuan()
    {
        return $this->BelongsTo(Satuan::class);
    }

    public function jenis()
    {
        return $this->BelongsTo(Jenis::class);
    }
}