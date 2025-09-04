<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = ['item_name', 'total_quantity', 'base_price', 'status'];

    public function bids()
    {
        return $this->hasMany(AuctionBid::class);
    }
    public function remainingQuantity()
    {
        return $this->total_quantity - $this->bids()->whereIn('status', ['cicilan', 'lunas'])->sum('quantity_taken');
    }

    // public function remainingQuantity()
    // {
    //     return $this->total_quantity - $this->bids()->sum('quantity_taken');
    // }
}
