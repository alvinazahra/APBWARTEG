<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 1. Menampilkan daftar semua transaksi (khusus admin via route middleware)
    public function index()
    {
        $transactions = Transaction::with('menu')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Transaksi Warteg',
            'data' => $transactions,
        ]);
    }

    // 2. Memproses pembelian / transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|integer|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $result = DB::transaction(function () use ($validated, $request) {
                // Kunci baris menu agar stok tidak tabrakan saat request bersamaan
                $menu = Menu::where('id', $validated['menu_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($menu->stock < $validated['quantity']) {
                    return [
                        'error' => true,
                        'status' => 422,
                        'message' => 'Stok tidak cukup! Sisa stok menu ini tinggal: ' . $menu->stock,
                    ];
                }

                $totalPrice = $menu->price * $validated['quantity'];

                $menu->decrement('stock', $validated['quantity']);

                $payload = [
                    'menu_id' => $menu->id,
                    'quantity' => $validated['quantity'],
                    'total_price' => $totalPrice,
                ];

                if ($request->user()) {
                    $payload['user_id'] = $request->user()->id;
                }

                $transaction = Transaction::create($payload);
                $transaction->load('menu');

                return [
                    'error' => false,
                    'transaction' => $transaction,
                ];
            });

            if (!empty($result['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], $result['status']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Transaksi Berhasil! Stok menu sudah dipotong.',
                'data' => $result['transaction'],
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}