<?php

namespace App\Http\Controllers\Admin\POS;

use App\Http\Controllers\Controller;
use App\Models\Order\Detail;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\Type as ProductType;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Facades\TelegramFacade;
use App\Services\TelegramService;

class POSController extends Controller
{
    public function getProducts()
    {
        $data = ProductType::select('id', 'name')
            ->with([
                'products:id,name,image,type_id,unit_price'
            ])
            ->get();

        return response()->json($data, Response::HTTP_OK);
    }

    public function makeOrder(Request $req)
    {

        //==============================>> Check validation
        $this->validate($req, [
            'cart'      => 'required|json'
        ]);

        //==============================>> Get Current Login User to save who make orders.
        $user = JWTAuth::parseToken()->authenticate();

        // ===>> Create Order
        $order                  = new Order;
        $order->cashier_id      = $user->id;
        $order->total_price     = 0;
        $order->customer_id     = $user->id;
        $order->status_id       = $req->status_id;
        $order->type_id         = $req->type_id;
        $order->receipt_number  = $this->_generateReceiptNumber();
        $order->save();

        // ===>> Find Total Price & Order Detail
        $details    = [];
        $totalPrice = 0;
        $cart       = json_decode($req->cart); // Turn Json String to PHP Array.

        foreach ($cart as $productId => $qty) {

            $product = Product::find($productId);
            if ($product) {
                $details[] = [
                    'order_id'      => $order->id,
                    'product_id'    => $productId,
                    'qty'           => $qty,
                    'unit_price'    => $product->unit_price,
                ];

                $totalPrice +=  $qty * $product->unit_price;
            }
            $product->quantity = $product->quantity - $qty;
            $product->save();

            //find number of product less than 10%
            $less_than_10 = ($product->stock * 10)/100;

            //if product in stock less than 10% alert to telegram
            $product->quantity < $less_than_10 ? $this->_alertProductLessOfStock($product) : false;

        }

        // ===>> Save to Details
        Detail::insert($details);

        // ===>> Update Order
        $order->total_price     = $totalPrice;
        $order->ordered_at      = Date('Y-m-d H:i:s');
        $order->save();

        // add point for customer
        if($req->customer_phone){
            $customer =User::where('phone', $req->customer_phone)->first();
            if($customer){
                // 10$ = 2points
                $customer->point = ($order->total_price * 2)/10;
                $customer->save();
            }

        }


        // ===> Get Data for Client Reponse to view the order in Popup.
        $orderData = Order::select('*')
            ->with([
                'cashier:id,name,type_id',
                'cashier.type:id,name',
                'details:id,order_id,product_id,unit_price,qty',
                'details.product:id,name,type_id',
                'details.product.type:id,name'
            ])
            ->find($order->id);

        // Send Telegram Notification
        $this->_sendOrderNotification($orderData);

        return response()->json([
            'order'         => $orderData,
            'message'       => 'ការបញ្ជាទិញត្រូវបានបង្កើតដោយជោគជ័យ។'
        ], Response::HTTP_OK);
    }

    private function _generateReceiptNumber()
    {
        $number = rand(1000000, 9999999);
        $check  = Order::where('receipt_number', $number)->first();
        if ($check) {
            return $this->_generateReceiptNumber();
        }

        return $number;
    }

    private function _sendOrderNotification($dataOrder = null){

        $htmlMessage = "<b>ការបញ្ជាទិញទទួលបានជោគជ័យ!</b>\n";
        $htmlMessage .= "- លេខវិកយប័ត្រ៖ " . $dataOrder->receipt_number . "\n";
        $htmlMessage .= "- អ្នកគិតលុយ៖ " . $dataOrder->customer->name;

        $productList = '';
        $totalProducts = 0;

        foreach ($dataOrder->details as $detail) {
            $productList .= sprintf(
                "%-20s | %-15s | %-10s | %s\n",
                $detail->product->name,
                $detail->unit_price,
                $detail->qty,
                PHP_EOL
            );
            $totalProducts += $detail->qty;
        }

        $htmlMessage .= "\n---------------------------------------\n";
        $htmlMessage .= "ផលិតផល             | តម្លៃដើម(៛)     | បរិមាណ\n";
        $htmlMessage .= $productList . "\n";
        $htmlMessage .= "<b>* សរុបទាំងអស់៖</b> $totalProducts ទំនិញ $dataOrder->total_price ៛\n";
        $htmlMessage .= "- កាលបរិច្ឆេទ: " . $dataOrder->ordered_at;

        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_ORDER'));
    }

    private function _alertProductLessOfStock($dataProduct = null){
        $htmlMessage = "<b>ផលិតផលក្នុង Stock តិចជា 10 %: </b>\n";
        $htmlMessage .= "- លេខកូដ​   ៖ " . $dataProduct->code . "\n";
        $htmlMessage .= "- ឈ្មោះ​      ៖ " . $dataProduct->name . "\n";
        $htmlMessage .= "- ក្នុង stock ៖ " . $dataProduct->quantity . "\n";

        TelegramService::send($htmlMessage, env('TELEGRAM_CHAT_ID_ORDER'));

    }
}


