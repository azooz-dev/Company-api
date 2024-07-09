<?php

namespace App\Models;

use App\Models\Scopes\scopes\BuyerScope;
use App\Models\Transaction;
use App\Models\User;
use App\Transformers\Buyer\BuyerTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Buyer extends User
{
    use HasFactory;

    public $transformer = BuyerTransformer::class;


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
