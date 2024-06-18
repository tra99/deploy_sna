<?php

namespace App\Http\Controllers\Site;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


use App\Http\Controllers\Controller;
use App\Services\FileUpload;
use App\Services\TelegramService;



use App\Models\Order\Order;
use App\Models\User\Type;
use App\Models\User\User;
use App\Models\Order\Detail;

use App\Models\Product\Product;


class CustomerController extends Controller
{
    public function viewOrdersHistory($id)
    {
        $products = Order::select('id', 'receipt_number', 'cashier_id', 'status_id', 'type_id', 'total_price', 'discount', 'ordered_at', 'paid_at')
        ->where('customer_id',$id)
        ->with([
            'details',
            'type',
            'status'
        ]);

        $products = $products->get();

        return $products;

    }

    public function getOrderHistory(Request $req)
    {
        $data = Order::select('*')
            ->with([
                'cashier',
                'customer',
                'type',
                'details',
                'type',
                'status'
            ]);

        $user = JWTAuth::parseToken()->authenticate();
        $data = $data->where('customer_id', $user->id);

        $data = $data->orderBy('id', 'desc')->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function checkoutOrder(Request $req)
    {

        //==============================>> Check validation
        $this->validate($req, [
            'cart'      => 'required|json'
        ]);

        //==============================>> Get Current Login User to save who make orders.
        $user = JWTAuth::parseToken()->authenticate();

        // ===>> Create Order
        $order                  = new Order;
        $order->total_price     = 0;
        $order->customer_id     = $user->id;
        $order->status_id       = 1;
        $order->type_id         = 2;
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
        }

        // ===>> Save to Details
        Detail::insert($details);

        // ===>> Update Order
        $order->total_price     = $totalPrice;
        $order->ordered_at      = Date('Y-m-d H:i:s');
        $order->save();

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
        $this->_sendNotification($orderData);

        // sent succuess response to client back
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

    private function _sendNotification($dataOrder = null){

        $htmlMessage = "<b>ការបញ្ជាទិញទទួលបានជោគជ័យ!</b>\n";
        $htmlMessage .= "- លេខវិកយប័ត្រ៖ " . $dataOrder->receipt_number . "\n";
        $htmlMessage .= "- អតិថិជន៖ " . $dataOrder->customer->name;

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



}

