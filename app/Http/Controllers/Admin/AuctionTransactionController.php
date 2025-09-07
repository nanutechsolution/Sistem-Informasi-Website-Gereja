<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuctionTransaction;
use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Member;
use App\Models\AuctionPayment; // Tambah model ini
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuctionTransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = AuctionTransaction::with(['item', 'member', 'payments']);

        // Filter berdasarkan status pembayaran
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter berdasarkan jemaat
        if ($request->filled('member_id')) {
            $query->where('member_id', $request->member_id);
        }

        // Filter berdasarkan rentang tanggal transaksi
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Ambil hasil query yang sudah difilter
        $transactions = $query->latest()->get();
        $items = AuctionItem::where('total_quantity', '>', 0)->get();
        $members = Member::where('status', 'Aktif')->get();

        return view('admin.auctions.transactions', compact('transactions', 'items', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'auction_item_id' => 'required|exists:auction_items,id',
            'member_id' => 'required|exists:members,id',
            'quantity_bought' => 'required|integer|min:1',
            'final_price' => 'required|numeric|min:0',
            'initial_payment' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // tentukan status awal transaksi
            $initialPayment = $validated['initial_payment'] ?? 0;
            if ($initialPayment == 0) {
                $status = 'pending';
            } elseif ($initialPayment < $validated['final_price']) {
                $status = 'installment';
            } else {
                $status = 'paid';
            }
            $transaction = AuctionTransaction::create([
                'auction_item_id' => $validated['auction_item_id'],
                'member_id' => $validated['member_id'],
                'quantity_bought' => $validated['quantity_bought'],
                'final_price' => $validated['final_price'],
                'payment_status' => $status,
                'notes' => $validated['notes'],
            ]);
            // Jika ada pembayaran awal, catat sebagai cicilan pertama
            if ($validated['quantity_bought'] > $transaction->item->total_quantity) {
                return back()->with('error', 'Stok tidak cukup!');
            }
            if ($initialPayment > 0) {
                $payment = new AuctionPayment([
                    'amount_paid' => $initialPayment,
                    'payment_date' => Carbon::today(),
                    'notes' => $status === 'paid' ? 'Pelunasan awal' : 'Panjar Lelang'
                ]);
                $transaction->payments()->save($payment);
                // update saldo kas
                $kas = $transaction->item->kas;
                $kas->ks_saldo += $initialPayment;
                $kas->save();
            }
            // kurangi stok barang
            $item = $transaction->item;
            $item->total_quantity -= $validated['quantity_bought'];
            $item->save();
            DB::commit();
            return redirect()->route('admin.auction-transactions.index')
                ->with('success', 'Transaksi berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Record a new payment for a transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuctionTransaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function recordPayment(Request $request, AuctionTransaction $transaction)
    {
        $validated = $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $totalPaid = $transaction->payments()->sum('amount_paid') + $validated['amount_paid'];

        // tentukan status
        if ($totalPaid == 0) {
            $status = 'pending';
        } elseif ($totalPaid < $transaction->final_price) {
            $status = 'installment';
        } else {
            $status = 'paid';
        }

        // simpan detail pembayaran
        AuctionPayment::create([
            'auction_transaction_id' => $transaction->id,
            'amount_paid' => $validated['amount_paid'],
            'payment_date' => $validated['payment_date'],
            'notes' => $validated['notes'] ?? ($status == 'paid' ? 'Pelunasan' : 'Panjar Lelang')
        ]);

        // update saldo kas
        $kas = $transaction->item->kas;
        $kas->ks_saldo += $validated['amount_paid'];
        $kas->save();

        // update status transaksi
        $transaction->payment_status = $status;
        $transaction->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function getReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AuctionPayment::with(['transaction.item', 'transaction.member'])
            ->orderBy('created_at', 'desc');

        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        $payments = $query->get();
        $reportData = [];

        foreach ($payments as $payment) {
            if ($payment->transaction) {
                $memberName = $payment->transaction->member->full_name ?? 'N/A';
                $reportData[$memberName][] = [
                    'item_name' => $payment->transaction->item->name ?? 'N/A',
                    'amount_paid' => $payment->amount_paid,
                    'payment_date' => $payment->payment_date,
                    'is_lunas' => ($payment->transaction->payment_status === 'paid'),
                ];
            }
        }

        return view('admin.auctions.report', compact('reportData', 'startDate', 'endDate'));
    }

    /**
     * Show payment history for a specific transaction.
     *
     * @param  \App\Models\AuctionTransaction  $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPaymentHistory(AuctionTransaction $transaction)
    {
        $payments = $transaction->payments()->orderBy('payment_date', 'asc')->get();
        return response()->json($payments);
    }
}