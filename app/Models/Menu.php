<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'price', 'stock', 'description'];

    // Relasi: Menu ini milik 1 kategori tertentu
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}