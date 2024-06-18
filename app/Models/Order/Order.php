<?php

namespace App\Models\Order;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\Order\Detail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    public function cashier() : BelongsTo // M:1
    {
        return $this->belongsTo(User::class, 'cashier_id')
        ->select('id', 'name');
    }
    public function customer() : BelongsTo // M:1
    {
        return $this->belongsTo(User::class, 'customer_id')
        ->select('id', 'name', 'phone', 'point');
    }

    public function details(): HasMany// 1:M
    {
        return $this->hasMany(Detail::class, 'order_id')
         ->select('id', 'order_id', 'qty', 'product_id', 'unit_price')
        ->with([
            'product:id,name,image'
        ])
        ;
    }
    public function status() : BelongsTo //M:1
    {
        return $this->belongsTo(Status::class, 'status_id')
        ->select('id', 'name','color');

    }

    public function type() : BelongsTo //M:1
    {
        return $this->belongsTo(Type::class, 'type_id')
        ->select('id', 'name','color');
    }

}
