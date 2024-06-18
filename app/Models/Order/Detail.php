<?php

namespace App\Models\Order;

// ===================================================>> Core Library
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ===================================================>> Custom Library
use App\Models\Product\Product;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detail extends Model
{
    use HasFactory;
    protected $table = 'order_details';


    public function order() : BelongsTo //M:1
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product() : BelongsTo //M:1
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
