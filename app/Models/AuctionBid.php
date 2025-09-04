<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'member_id',
        'quantity_taken',
        'amount',
        'status',
        'payment_date'
    ];
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
