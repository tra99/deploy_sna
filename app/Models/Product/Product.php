<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


use App\Models\Product\Type;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\User\Favorite;
use App\Models\Order\Detail as OrderDetail;


class Product extends Model
{
    use HasFactory;
    protected $table = 'product';


    public function type(): BelongsTo //M:1
    {
        return $this->belongsTo(Type::class, 'type_id','id')->select('id', 'name');
    }
    public function category(): BelongsTo //M:1
    {
        return $this->belongsTo(Category::class, 'category_id','id')->select('id', 'name');
    }

    public function brand(): BelongsTo //M:1
    {
        return $this->belongsTo(Brand::class, 'brand_id','id')->select('id', 'name','logo');
    }

    public function images(): HasMany //1:M
    {
        return $this->hasMany(Image::class, 'product_id')->select('id', 'product_id', 'image', 'caption');
    }

    public function favorites(): HasMany //1:M
    {
        return $this->hasMany(Favorite::class, 'product_id');
    }

    public function orders(): HasMany //1:M
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function promotions(): HasMany //1:M
    {
        return $this->hasMany(Promotion::class, 'product_id');
    }

}
