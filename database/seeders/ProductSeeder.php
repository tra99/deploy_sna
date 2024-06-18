<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        /*
        |-------------------------------------------------------------------------------
        | Add Product Type First because relationship from products_type to products 1:M
        |-------------------------------------------------------------------------------
        */



        DB::table('products_type')->insert(
            [
                ['name' => 'Athletic Shoes',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Formal Shoes',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Sandals',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Boots',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
            ]
        );

        // Category
        DB::table('products_category')->insert(
            [
                ['name' => 'Kids',
                 'icon' => '/',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                 'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                ['name' => 'Men',
                 'icon' => '/',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                 'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                ['name' => 'Women',
                 'icon' => '/',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                 'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],

            ]
        );
        $uri = 'static/Brands/';
        // Brand
        DB::table('products_brand')->insert(
            [
                ['name' => 'Nike',
                 'logo' => $uri.'Nike.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                 'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s'),
                ],
                ['name' => 'Adidas',
                 'logo' => $uri.'Adidas.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Amberjack',
                 'logo' => $uri.'Amberjack.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Vans',
                 'logo' => $uri.'Vans.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Puma',
                 'logo' => $uri.'Puma.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Birkenstock',
                 'logo' => $uri.'Birkenstock.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ],
                ['name' => 'Schutz',
                 'logo' => $uri.'Schutz.png',
                 'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    =>  Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]
        );



        /*
        |-------------------------------------------------------------------------------
        | Add 20 Products
        |-------------------------------------------------------------------------------
        */



        $products = [
            "RS-X Sweater Weather Toddlers' Sneakers",
            "Jordan 6 Retro",
            "Kids Classic Slip-On Color Block Shoe",
            "Suede Classic XXI Sneakers Big Kids",
            "Rapidasport Bounce Elastic Lace Top Strap Shoes",
            "The Loafer",
            "Air Jordan 1 Retro High OG Yellow Ochre",
            "Gazelle Indoor Shoes",
            "The Original",
            "Old Skool Shoe",
            "Maryana Boot",
            "Anya Leather Sandal",
            "Elsa Pump",
            "Soley",
            "Mary",
        ];

        $data =[];
        $i = 0;

        $images = [];

        foreach($products as $product){

            $i++;

            $category_id = 1;

            if($i>= 5 && $i <=9 ){
                $category_id = 2;
            }else if($i >= 10){
                $category_id = 3;

            }

            $data[] = [
                    'code'          =>  'P00'.rand(10,99),
                    'type_id'       =>  rand(1,4),
                    'brand_id'      =>  rand(1,7),
                    'category_id'   =>  $category_id,
                    'name'          =>  $product,
                    'unit_price'    =>  rand(50,300),
                    // 'discount'      =>  rand(300,400),
                    'image'         =>  'static/Products/'.$i.'/img.png',
                    'cover'         =>  'static/Products/'.$i.'/cover.png',
                    'size'          =>  rand(30,45),
                    'quantity'      =>  rand(30,100),
                    'description'   =>  'Genuine leather, Wings logo stamped on collar, Stitched-down Swoosh logo, Rubber traction, Foam sole, Shown: Yellow Orche/Sail/Black, Style: DZ5485-701',
                    'is_available'  =>  rand(0,1),
                    'created_at'    =>  now(),
                    'updated_at'    =>  now()

            ];

            $images[] = ['product_id'=>$i, 'image'=>'static/Products/'.$i.'/img.png','caption'=>'main'];
            $images[] = ['product_id'=>$i, 'image'=>'static/Products/'.$i.'/img1.png','caption'=>'first'];
            $images[] = ['product_id'=>$i, 'image'=>'static/Products/'.$i.'/img2.png','caption'=>'second'];
            $images[] = ['product_id'=>$i, 'image'=>'static/Products/'.$i.'/img3.png','caption'=>'third'];

        }

        DB::table('product')->insert($data);
        DB::table('product_images')->insert($images);

    }
}
