<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'auction_item_id',
        'member_id',
        'quantity_bought',
        'final_price',
        'payment_status',
        'notes',
    ];

    /**
     * Get the auction item associated with the transaction.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(AuctionItem::class, 'auction_item_id');
    }

    /**
     * Get the member that made the transaction.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function payments()
    {
        return $this->hasMany(AuctionPayment::class);
    }
}
