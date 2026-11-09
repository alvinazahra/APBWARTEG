<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 1. Menampilkan daftar semua transaksi
    public function index()
    {
        $transactions = Transaction::with('menu')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Transaksi Warteg',
            'data' => $transactions
        ]);
    }

    // 2. Memproses pembelian / transaksi baru
    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Gunakan Database Transaction biar aman (kalau gagal, rollback otomatis)
        DB::beginTransaction();

        try {
            // Ambil data menu berdasarkan ID
            $menu = Menu::findOrFail($request->menu_id);

            // Cek apakah stok mencukupi
            if ($menu->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup! Sisa stok menu ini tinggal: ' . $menu->stock
                ], 400);
            }

            // Hitung total harga (harga satuan x jumlah beli)
            $totalPrice = $menu->price * $request->quantity;

            // Kurangi stok menu secara otomatis
            $menu->stock -= $request->quantity;
            $menu->save();

            // Simpan data transaksi ke database
            $transaction = Transaction::create([
                'menu_id' => $menu->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi Berhasil! Stok menu sudah dipotong.',
                'data' => $transaction
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}