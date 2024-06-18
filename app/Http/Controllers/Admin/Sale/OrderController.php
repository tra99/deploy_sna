<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Enum\OrderStatus;

class OrderController extends Controller
{
    function isValidDate($date)
    {
        if (false === strtotime($date)) {
            return false;
        } else {
            return true;
        }
    }

    public function listing(Request $req)
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

        // ==============================>> Date Range
        if ($req->from && $req->to && $this->isValidDate($req->from) && $this->isValidDate($req->to)) {
            $data = $data->whereBetween('created_at', [$req->from . " 00:00:00", $req->to . " 23:59:59"]);
        }

        // =========================== Search receipt number
        if ($req->receipt_number && $req->receipt_number != "") {
            $data = $data->where('receipt_number', $req->receipt_number);
        }

        // ========================== search filter status
        if ($req->receipt_number) {
            $data = $data->where('receipt_number', $req->receipt_number);
        }

        // ===========================>> If Not admin, get only record that this user make order
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->type_id == 2) { //Manager
            $data = $data->where('cashier_id', $user->id);
        }

        $data = $data->orderBy('id', 'desc')
            ->paginate($req->limit ? $req->limit : 10);
        return response()->json($data, Response::HTTP_OK);
    }
    public function delete($id = 0)
    {
        $data = Order::find($id);

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
                'message' => 'ទិន្នន័យមិនត្រឹមត្រូវ។',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function takeAction(Request $req, $id = 0){
        // find record
        $data = Order::find($id);

        //==============================>> Get Current Login User to save who make orders.
        $user = JWTAuth::parseToken()->authenticate();

        if($data){
            $data->cashier_id = $user->id  ;

            $data->status_id    = $req->action == 1 ? OrderStatus::PAID : OrderStatus::REJECTED;

            $data->save();

            $message = $req->action == 1 ? "ការបញ្ជាទិញត្រូវបានយល់ព្រម" : "ការបញ្ជាទិញត្រូវបានបដីសេធ";

            $data = Order::select('*')
            ->with([
                'cashier',
                'customer',
                'type',
                'details',
                'type',
                'status'
            ])
            ->find($id);

            return response()->json([
                'data'      => $data,
                'status'    => 'ជោគជ័យ',
                'message'   => $message,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status'    => 'បរាជ័យ',
                'message' => 'ទិន្នន័យមិនត្រឹមត្រូវ',
            ], Response::HTTP_BAD_REQUEST);
        }

    }
}
