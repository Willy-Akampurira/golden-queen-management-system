<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\Feedback;

class Order extends Model
{
    //use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'menu_item_id',
        'quantity',
        'status',
        'table_number',
        'customer_name',
        'gender',
        'drinks',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the menu item associated with the order.
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Get the feedback associated with the order.
     */
    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }
}
