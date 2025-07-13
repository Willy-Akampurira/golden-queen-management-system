<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'unit',
        'quantity',
        'reorder_level',
        'unit_price',
        'supplier',
    ];

    /**
     * Get all transactions for this inventory item.
     */
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
