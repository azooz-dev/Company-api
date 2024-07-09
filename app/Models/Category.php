<?php

namespace App\Models;

use App\Models\Product;
use App\Transformers\Category\CategoryTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $date = ['deleted_at'];
    protected $hidden = ['pivot'];
    public $transformer = CategoryTransformer::class;

    protected $fillable = [
        'name',
        'description',
    ];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
