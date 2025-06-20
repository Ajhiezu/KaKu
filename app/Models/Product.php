<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'image', 'barcode', 'name', 'unit', 'stock',
        'purchase_price', 'selling_price', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
