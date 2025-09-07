<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Kas;
use Illuminate\Http\Request;

class AuctionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = AuctionItem::all();
        $kas = Kas::all();
        return view('admin.auctions.index', compact('items', 'kas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'total_quantity' => 'required|integer|min:1',
            'ks_id' => 'required|integer'
        ]);
        AuctionItem::create($validatedData);
        return redirect()->route('admin.auction_items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuctionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function show(AuctionItem $item)
    {

        return view('auctions.item_details', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuctionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuctionItem $item)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'total_quantity' => 'required|integer|min:1',
            'ks_id' => 'required|integer'
        ]);

        $item->update($validatedData);

        return redirect()->route('admin.auction_items.index')->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuctionItem  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuctionItem $item)
    {
        $item->delete();
        return redirect()->route('admin.auction_items.index')->with('success', 'Barang berhasil dihapus!');
    }
}