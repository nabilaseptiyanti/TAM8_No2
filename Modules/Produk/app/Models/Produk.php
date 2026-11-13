<?php

namespace Modules\Produk\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_produk',
        'kategori',
        'harga',
        'stok',
        'deskripsi',
        'foto',
        'nama_foto',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'foto_url',
        'formatted_harga',
    ];

    /**
     * Accessor for full photo URL.
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->foto) {
                    return null;
                }
                return Storage::disk('public')->url($this->foto);
            }
        );
    }

    /**
     * Accessor for Indonesian Rupiah formatted price.
     */
    protected function formattedHarga(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format((float) $this->harga, 0, ',', '.')
        );
    }
}
