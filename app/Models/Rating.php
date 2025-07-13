<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'menu_item_id',
        'user_id',
        'rating',
    ];

    /**
     * Each rating belongs to a specific menu item.
     */
    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * Optional relationship to the user who submitted the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
