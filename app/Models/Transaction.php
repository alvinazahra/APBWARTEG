<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'quantity', 'total_price'];

    // Relasi: Transaksi ini mencatat 1 menu tertentu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}