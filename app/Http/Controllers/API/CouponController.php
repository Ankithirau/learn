<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validate_coupon(Request $request)
    {
        $request->validate(
            [
                'promo_code' => 'required|string',
                'cart_amount' => 'required|string'
            ]
        );
        try {
            $code  = Coupon::where('promo_code', $request->promo_code)->get();

            if ($code->count() > 0) {
                $data = [];
                if ($code[0]->status == 1) {
                    if ($code[0]->is_one_time == 0) {
                        $code = $code;
                        if ($request->cart_amount >= $code[0]->minimum_amount) {
                            $status = 200;
                            $msg = 'coupon applied';
                            $data['promo_coupon_id'] = $code[0]->id;
                            $data['amount'] = $code[0]->value;
                        } else {
                            $status = 400;
                            $msg = 'cart amount must be above 2000 euro';
                        }
                    } else {
                        $status = 400;
                        $msg = 'coupon code is already used';
                    }
                } else {
                    $status = 400;
                    $msg = 'coupon code deactivated';
                }
            } else {
                $msg = 'invalid coupon code';
            }

            $response = array('status' => $status, 'msg' => $msg, 'data' => $data);
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $msg);
        }
        return response()->json($response);
    }
}
