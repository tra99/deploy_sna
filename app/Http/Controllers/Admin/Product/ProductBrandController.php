<?php

namespace App\Http\Controllers\Admin\Product;

//=============================================================================>> Core Library
use Illuminate\Http\Request;            // for getting data form client
use Illuminate\Http\Response;           // for returning data back to client

//=============================================================================>> Third Party Library 

//=============================================================================>> Custom Library
use App\Http\Controllers\Controller;
use App\Models\Product\Brand;           // for getting brand data form database

class ProductBrandController extends Controller
{
    public function listing()
    {
        $data = Brand::select("*")
        // ->with([
        //     'products:id,brand_id,name,image' 
        // ])
        ->withCount([
            'products as n_of_products'
        ])
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }

    public function create(Request $req)
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'             => 'required|max:20',
            ],
            [ 
                'name.required'    => 'សូមបញ្ចូលឈ្មោះម៉ាកផលិតផល',
                'name.max'         => 'ឈ្មោះម៉ាកផលិតផលមិនអាចលើសពី២០ខ្ទង់',
            ]
        );
        
        //==============================>> Start Adding data
        $data           =   new Brand;
        $data->name     =   $req->name;
        $data->save();
    
        return response()->json([
            'data'          => $data,
            'message'       => 'ទិន្នន័យត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }

    public function update(Request $req, $id = 0) 
    {
        //==============================>> Check validation
        $this->validate(
            $req,
            [
                'name'             => 'required|max:20',
            ],
            [ 
                'name.required'    => 'សូមបញ្ចូលឈ្មោះម៉ាកផលិតផល',
                'name.max'         => 'ឈ្មោះម៉ាកផលិតផលមិនអាចលើសពី២០ខ្ទង់',
            ]
        );
        
        //==============================>> Start updating data
        $data           =   Brand::find($id);

        if ($data) {

            $data->name     =   $req->name;
            $data->save();

            return response()->json([
                'status'        => 'ជោគជ័យ',
                'message'       => 'ប្រភេទផលិតផលត្រូវបានកែប្រែជោគជ័យ!',
                'data'          => $data,
            ], Response::HTTP_OK);
            
        }else {

            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
            
        }
    }

    public function delete($id)
    {
        $data           =   Brand::find($id);

        if ($data) {

            $data->delete();

            return response()->json([
                'status'        => 'ជោគជ័យ',
                'message'       => 'data has been deleted!',
            ], Response::HTTP_OK);
            
        }else {

            return response()->json([
                'status'    => 'បរាជ័យ',
                'message'   => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
            
        }
    }
}
