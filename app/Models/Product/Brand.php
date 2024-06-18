<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'products_brand';

    public function products(): HasMany //1:M
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
