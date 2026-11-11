<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name',
        'price',
        'capacity',
        'size',
        'description',
        'facilities',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'facilities' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Kamar aktif, diurutkan, dan diberi key berdasarkan nama tipe
     * (contoh: $rooms['Deluxe']).
     */
    public static function activeByName(): Collection
    {
        return static::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('name');
    }

    public function getFormattedPriceAttribute(): string
    {
        return rupiah($this->price);
    }
}
