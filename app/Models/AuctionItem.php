<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuctionItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'total_quantity',
    ];

    /**
     * Get the auction transactions for the item.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(AuctionTransaction::class);
    }
}
