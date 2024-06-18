<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorite';


    public function user(): BelongsTo //M:1
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product(): BelongsTo //M:1
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
