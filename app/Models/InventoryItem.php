<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'quantity',
        'location',
        'condition',
        'photo',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function loans(): HasMany
    {
        return $this->hasMany(InventoryLoan::class);
    }

    public function getAvailableQuantityAttribute(): int
    {
        $borrowedQuantity = $this->loans()
            ->whereNull('returned_at')
            ->sum('quantity');

        return max(0, $this->quantity - $borrowedQuantity);
    }
}
