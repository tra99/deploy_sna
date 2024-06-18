<?php

namespace Database\Seeders;

use App\Models\Order\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ============ Order Status ============ \\
        DB::table('orders_status')->insert([
            ['name' => 'Pending', 'color' => '#FFA500'], // Orange color for 'pending' status
            ['name' => 'Paid', 'color' => '#00FF00'], // Green color for 'paid' status
            ['name' => 'Rejected', 'color' => '#FF0000'], // red color for 'pending' status
            ['name' => 'Cancelled', 'color' => '#FF0000'], // Red color for 'cancelled' status
        ]);

        // ============ Order Status ============ \\
        DB::table('orders_type')->insert([
            ['name' => 'Onside', 'color' => '#964B00'], // brown color for 'Onside' type
            ['name' => 'Online', 'color' => '#0000FF'], // blue color for 'paid' type

        ]);



        // ===>> Create Order Records
        $data = [];
        for ($i = 1; $i <= 10; $i++) {

            $data[] = [
                'receipt_number'    => $this->generateReceiptNumber(),
                'cashier_id'        => rand(1, 3),
                'customer_id'       => 4,
                'status_id'         => rand(1,4),
                'type_id'           => rand(1,2),
                'total_price'       => 0,
                'ordered_at'        => Date('Y-m-d H:i:s')
            ];
        }

        // ===>> Create Order Records
        DB::table('order')->insert($data);

        // ===>> Create Order Order Detail
        $orders = Order::get();
        foreach ($orders as $order) {

            $details        = [];
            $totalPrice     = 0; // To Save in table order
            $nOfDetails     = rand(1, 6); //ចំនួនផលិតផលនៅក្នុងបុង

            for ($i = 1; $i <= $nOfDetails; $i++) {

                $product    = DB::table('product')->find(rand(1, 14));
                $qty        = rand(1, 10);
                $totalPrice += $product->unit_price * $qty;

                $details[] = [
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'qty'           => $qty,
                    'unit_price'    => $product->unit_price
                ];
            }

            DB::table('order_details')->insert($details);


            // ==>> Update table order for total price.
            $order->total_price     = $totalPrice;
            $order->save();
        }
    }

    public function generateReceiptNumber()
    {

        $number     = rand(100000, 999999);
        $check      = DB::table('order')->where('receipt_number', $number)->first();

        if ($check) {
            return $this->generateReceiptNumber();
        } else {
            return $number;
        }
    }
}
