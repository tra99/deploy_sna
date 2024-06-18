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
use App\Models\Product\Brand;


class HomeController extends Controller
{
    public function home(Request $req)
    {
        $data = [
            'slides'                => $this->getSlides(),
            'brands'                => $this->getBrands(),
            'trendings'             => [],
            'discounts'             => [],
            'best_selling_products' => $this->getBestSellingProducts(),
            'featured_products'     => $this->getFeaturedProducts()
        ];
        return $data;
    }

    private function getSlides(){

        return [];
    }

    private function getBestSellingProducts(){
        $products = Product::select('id', 'name', 'image', 'brand_id', 'unit_price')
        ->with([
            'brand',

        ])
        ->withCount(['orders as n_of_orders'])
        ->where('is_featured', 1)
        ->limit(5)
        ->orderBy('n_of_orders','DESC')
        ->get();

        return $products;
    }

    private function getFeaturedProducts(){

        $products = Product::select('id', 'name', 'image','cover', 'brand_id', 'unit_price', 'discount')
        ->with([
            'brand',
        ])
        ->where('is_featured', 1)
        ->limit(5)
        ->get();

        return $products;
    }

    private function getBrands()
    {

        $brands = Brand::select('id', 'name', 'logo')
        ->get();
        return $brands;

    }


}

