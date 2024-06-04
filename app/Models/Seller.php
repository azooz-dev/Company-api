<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\scopes\SellerScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Seller extends User
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
