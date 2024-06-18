<?php

namespace App\Http\Controllers\Admin\Product;

// ================================>> Core Library
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// ================================>> Third Party
use Carbon\Carbon;

// ================================>> Custome Library
use App\Http\Controllers\Controller;
use App\Models\Product\Product;

use App\Services\FileUpload;

class ProductController extends Controller
{
    public function listing(Request $req)
    {
        $data = Product::select('*')
        ->with(['type'])
        ->withCount(['orders as n_of_orders']);

        //Filter
        if ($req->key && $req->key != '') {
            $data = $data->where('code', 'LIKE', '%' . $req->key . '%')->Orwhere('name', 'LIKE', '%' . $req->key . '%');
        }

        if ($req->type && $req->type != 0) {
            $data = $data->where('type_id', $req->type);
        }

        $data = $data->orderBy('id', 'desc')->paginate($req->limit ? $req->limit : 10,'per_page');
        return response()->json($data, Response::HTTP_OK);

    }

    public function view($id = 0)
    {
        $data = Product::select('*')->find($id);
        if($data){

            return response()->json($data, Response::HTTP_OK);

        }else{

            return response()->json([
                'status'    => 'fil',
                'message'   => 'គ្មានទិន្ន័យ',
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function create(Request $req)
    {

        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'              => 'required|max:50',
                'code'              => 'required|max:20',
                'unit_price'        => 'required|numeric',
                'type_id'           => 'required|exists:products_type,id',
                'category_id'       => 'required|exists:products_category,id',
                'brand_id'          => 'required|exists:products_brand,id',
                'quantity'          => 'required',
                'size'              => 'required',
                'description'       => 'required',

            ],
            [
                'name.required'         => 'សូមបញ្ចូលឈ្មោះផលិតផល',
                'name.max'              => 'ឈ្មោះផលិតផលមិនអាចលើសពី50ខ្ទង់',

                'code.required'         => 'សូមបញ្ចូលឈ្មោះលេខកូដផលិតផល',
                'code.max'              => 'សូមបញ្ចូលឈ្មោះលេខកូដផលិតផលមិនអាចលើសពី២០ខ្ទង់',

                'unit_price.required'   => 'សូមបញ្ចូលតម្លៃរាយ',
                'unit_price.numeric'    => 'សូមបញ្ចូលតម្លៃរាយជាលេខ',

                'type_id.exists'        => 'សូមជ្រើសរើសឈ្មោះ ក្រុម អោយបានត្រឹមត្រូវ',
                'category_id.exists'    => 'សូមជ្រើសរើសឈ្មោះ ប្រភេទ អោយបានត្រឹមត្រូវ',
                'brand_id.exists'       => 'សូមជ្រើសរើសឈ្មោះ​ ម៉ាក អោយបានត្រឹមត្រូវ'

            ]
        );

        //==============================>> Start Saving Data to Database
        $product                =   new Product;
        $product->name          =   $req->name;
        $product->code          =   $req->code;
        $product->type_id       =   $req->type_id;
        $product->category_id   =   $req->category_id;
        $product->brand_id      =   $req->brand_id;
        $product->description   =   $req->description;
        $product->is_available  =   1;
        $product->quantity      =   $req->quantity;
        $product->stock         =   $req->quantity;
        $product->size          =   $req->size;
        $product->unit_price    =   $req->unit_price;
        $product->save();

        //==============================>> Start Uploading Image to File Server
        if ($req->image) {
            // Need to create folder before storing images
            $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
            $image  = FileUpload::uploadFile($req->image, 'products/', $req->fileName);

            //if ($image['url']) {
                $product->image = $image['url'];
                $product->save();
            //}
        }
        if ($req->cover) {
            // Need to create folder before storing images
            $folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
            $image  = FileUpload::uploadFile($req->cover, 'products/covers/', $req->fileName);

            //if ($image['url']) {
                $product->cover = $image['url'];
                $product->save();
            //}
        }

        return response()->json([
            'data'      =>  Product::select('*')->with(['type','brand','category'])->find($product->id),
            'message'   => 'ផលិតផលត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }

    public function update(Request $req, $id = 0)
    {
        // return "Yes";
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'              => 'required|max:50',
                'code'              => 'required|max:20',
                'unit_price'        => 'required|numeric',
                'type_id'           => 'required|exists:products_type,id',
                'category_id'       => 'required|exists:products_category,id',
                'brand_id'          => 'required|exists:products_brand,id',
                'size'              => 'required',
                'description'       => 'required',
                'is_available'       => 'required',

            ],
            [
                'name.required'         => 'សូមបញ្ចូលឈ្មោះផលិតផល',
                'name.max'              => 'ឈ្មោះផលិតផលមិនអាចលើសពី50ខ្ទង់',

                'code.required'         => 'សូមបញ្ចូលឈ្មោះលេខកូដផលិតផល',
                'code.max'              => 'សូមបញ្ចូលឈ្មោះលេខកូដផលិតផលមិនអាចលើសពី២០ខ្ទង់',

                'unit_price.required'   => 'សូមបញ្ចូលតម្លៃរាយ',
                'unit_price.numeric'    => 'សូមបញ្ចូលតម្លៃរាយជាលេខ',

                'type_id.exists'        => 'សូមជ្រើសរើសឈ្មោះ ក្រុម អោយបានត្រឹមត្រូវ',
                'category_id.exists'    => 'សូមជ្រើសរើសឈ្មោះ ប្រភេទ អោយបានត្រឹមត្រូវ',
                'brand_id.exists'       => 'សូមជ្រើសរើសឈ្មោះ​ ម៉ាក អោយបានត្រឹមត្រូវ'

            ]
        );
        $product                =   new Product;

        //==============================>> Start Updating data
        $product                         = Product::find($id);
        if ($product) {

            $product->name          =   $req->name;
            $product->code          =   $req->code;
            $product->type_id       =   $req->type_id;
            $product->category_id   =   $req->category_id;
            $product->brand_id      =   $req->brand_id;
            $product->description   =   $req->description;
            $product->is_available  =   $req->is_available;
            $product->size          =   $req->size;
            $product->unit_price    =   $req->unit_price;
            $product->save();


            // Image Upload
            if ($req->image) {

                // Need to create folder before storing images
                //$folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
                $folder = Carbon::today()->format('d-m-y');

                //return $folder;

                $image  = FileUpload::uploadFile($req->image, 'products', $req->fileName);

                //return $image;

                if ($image['url']) {

                    $product->image     = $image['url'];
                    $product->save();

                }
            }
            if ($req->cover) {

                // Need to create folder before storing images
                //$folder = Carbon::today()->format('d') . '-' . Carbon::today()->format('M') . '-' . Carbon::today()->format('Y');
                $folder = Carbon::today()->format('d-m-y');

                //return $folder;

                $image  = FileUpload::uploadFile($req->cover, 'products/covers', $req->fileName);

                //return $image;

                if ($image['url']) {

                    $product->cover     = $image['url'];
                    $product->save();

                }
            }

            // Prepare Data backt to Client
            $product = Product::select('*')
            ->with([
                'type','category','brand'
            ])
            ->find($id);

            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ផលិតផលត្រូវបានកែប្រែជោគជ័យ',
                'product'   => $product,
            ], Response::HTTP_OK);

        } else {

            return response()->json([

                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',

            ], Response::HTTP_BAD_REQUEST);

        }
    }

    public function delete($id = 0)
    {
        $data = Product::find($id);

        //==============================>> Start deleting data
        if ($data) {

            $data->delete();
            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ទិន្នន័យត្រូវបានលុប',
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function add_stock(Request $req, $id = 0)
    {
        // return "Yes";
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'code'              => 'required|exists:product,code',
                'new_stock'         => 'required'


            ],
            [
                'code.required'         => 'សូមបញ្ចូលឈ្មោះលេខកូដផលិតផល',
                'code.max'              => 'សូមបញ្ចូលឈ្មោះលេខកូដផលិតផល ឲបានត្រឹមត្រូវ',

                'new_stock'             => 'សូមបញ្ចូលចំនួន stock ផលិតផល',

            ]
        );
        $product                =   new Product;

        //==============================>> Start Updating data
        $product                         = Product::find($id);
        if ($product) {

            $product->quantity    = $product->quantity  + $req->new_stock;
            $product->stock       = $product->quantity;

            $product->save();

            // Prepare Data backt to Client
            $product = Product::select('*')
            ->with([
                'type','category','brand'
            ])
            ->find($id);

            return response()->json([
                'status'    => 'ជោគជ័យ',
                'message'   => 'ផលិតផលត្រូវបានបន្ថែម Stock ថ្មី',
                'product'   => $product,
            ], Response::HTTP_OK);

        } else {

            return response()->json([

                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',

            ], Response::HTTP_BAD_REQUEST);

        }
    }
}
