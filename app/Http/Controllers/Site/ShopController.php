<?php

namespace App\Http\Controllers\Site;

use Carbon\Carbon;
use App\Models\User\Type;
use App\Models\User\User;
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\Product\Product;


class ShopController extends Controller
{
    public function getProducts(Request $req)
    {
        $products = Product::select('id', 'name', 'image', 'type_id', 'category_id', 'unit_price', 'discount', 'size', 'quantity')
        ->with([
            // 'type',
            'category',
            // 'images'
        ]);


        $products = $products->get();

        return $products;

    }

    public function viewProduct($id = 0)
    {
        $products = Product::select('*')
        ->with([
            'type',
            'category',
            'images'
        ])
        ->find($id);

        return $products;

    }

}

