<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\Member;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::all();

        // Contoh 3 barang lelang
        $items = [
            ['item_name' => 'Daging Kurban', 'total_quantity' => 10, 'base_price' => 100000],
            ['item_name' => 'Gula Pasar', 'total_quantity' => 5, 'base_price' => 50000],
            ['item_name' => 'Sarung', 'total_quantity' => 3, 'base_price' => 75000],
        ];

        foreach ($items as $item) {
            $auction = Auction::create($item);

            // Random beberapa member ambil barang
            $members->random(rand(1, $members->count()))->each(function ($member) use ($auction) {
                $quantity = rand(1, min(2, $auction->total_quantity));
                AuctionBid::create([
                    'auction_id' => $auction->id,
                    'member_id' => $member->id,
                    'quantity_taken' => $quantity,
                    'amount' => $quantity * $auction->base_price,
                    'status' => ['pending', 'cicilan', 'lunas'][array_rand(['pending', 'cicilan', 'lunas'])],
                    'payment_date' => now(),
                ]);
            });
        }
    }
}
