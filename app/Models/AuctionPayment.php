<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_transaction_id',
        'amount_paid',
        'payment_date',
        'notes',
    ];

    public function transaction()
    {
        return $this->belongsTo(AuctionTransaction::class, 'auction_transaction_id');
    }
    public function getIsInstallmentAttribute()
    {
        return $this->transaction->payment_status === 'installment';
    }
}