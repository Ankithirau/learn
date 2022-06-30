<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Coupon::orderBy('id', 'DESC')->get();

        return view("coupon.index", compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->minimum_amount);
        $requested_data = $request->except(['_token', '_method']);
        $request->validate(
            [
                'promo_code' => ['required', 'string', Rule::unique('coupon_code', 'promo_code')],
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'discount_type' => 'required|string',
                'minimum_amount' => 'required|integer',
                'value' => 'required|integer',
                'status' => 'required|string',
            ],
            [
                'promo_code.required'      => 'Coupon code is required.',
                'start_date.required'      => 'Start date is required.',
                'end_date.required'      => 'End date is required.',
                'discount_type.required'      => 'Discount type is required.',
                'minimum_amount.required'      => 'Minimum Cart Amount type is required.',
                'value.required'      => 'Discount is required.',
                'status.required'      => 'Status is required.',
            ]
        );
        try {
            $store  = new Coupon();
            foreach ($requested_data as $key => $data) {
                $store->$key = $data;
            }
            $store->created_by = Auth::user()->id;
            $store->save();
            $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th);
        }
        return json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result =  Coupon::find($id);
        if ($result) {
            $response = array('status' => 200, 'result' => $result);
        } else {
            $response = array('status' => 400, 'msg' => 'Something went wrong...!');
        }
        return json_encode($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requested_data = $request->except(['_token', '_method']);
        $request->validate(
            [
                'coupon_code' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'discount_type' => 'required|string',
                'discount' => 'required|string',
                'status' => 'required|string',
            ],
            [
                'coupon_code.required'      => 'Coupon code is required.',
                'start_date.required'      => 'Start date is required.',
                'end_date.required'      => 'End date is required.',
                'discount_type.required'      => 'Discount type is required.',
                'discount.required'      => 'Discount is required.',
                'status.required'      => 'Status is required.',
            ]
        );
        try {
            $update  = Coupon::find($id);
            foreach ($requested_data as $key => $data) {
                $update->$key = $data;
            }
            $update->save();
            $response = array('status' => 200, 'msg' => 'Data updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }

        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupon::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }

    public function status($id)
    {
        try {
            $update  = Coupon::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return json_encode($response);
    }
}
