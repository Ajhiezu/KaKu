<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt_Payment extends Model
{
    protected $fillable = ['debt_id', 'payment_amount', 'payment_date'];

     protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
