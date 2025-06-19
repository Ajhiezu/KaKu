<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
     use SoftDeletes;

    protected $fillable = ['name', 'phone', 'address'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }
}
