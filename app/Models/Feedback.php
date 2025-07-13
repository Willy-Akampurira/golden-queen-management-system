<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Order;

class Feedback extends Model
{
    use HasFactory;

    // Explicitly define the table name for safety
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'order_id',
        'rating',
        'comment',
        'admin_reply',
        'name', // for guests
    ];

    /**
     * Get the user who gave the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order this feedback is associated with.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
