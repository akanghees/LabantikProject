<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_item_id',
        'member_id',
        'borrower_name',
        'quantity',
        'loaned_at',
        'due_at',
        'returned_at',
        'condition_returned',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'loaned_at' => 'date',
            'due_at' => 'date',
            'returned_at' => 'date',
        ];
    }

    public function inventoryItem(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
