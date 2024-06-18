<?php

namespace App\Models\Order;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\Order\Detail;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;
    protected $table = 'orders_type';

    public function orders() : HasMany //1:M
    {
        return $this->hasMany(Order::class, 'type_id');
    }

}
