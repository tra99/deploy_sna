<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Product\Type;

class Image extends Model
{
    use HasFactory;
    protected $table = 'product_images';


    public function product(): BelongsTo //M:1
    {
        return $this->belongsTo(Product::class, 'product_id')->select('id', 'name');
    }

}
