<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\County;
use App\Models\Event;
use App\Models\Pick_Point;
use App\Models\Product;
use App\Models\Product_variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results =  Product::select('id', 'name', 'price', 'image', 'category_id')->get();

        foreach ($results as $key => $event) {

            $event->price =  $event->price;

            $event->image = asset('uploads/event_image') . '/' . $event->image;
        }

        if ($results->count() > 0) {

            $response = array('status' => 200, 'data' => $results);
        } else {

            $response = array('status' => 500, 'msg' => 'No Record Founds');
        }
        return response()->json($response);
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pickuppoint_by_county(Request $request, $id)
    {
        $pickup = Pick_Point::where(['id' => $id])->get()->makeHidden(['created_by', 'status', 'created_at', 'updated_at']);

        if ($pickup->count() > 0) {
            $response = array('status' => 200, 'data' => $pickup);
        } else {
            $response = array('status' => 500, 'msg' => 'No Record Found');
        }

        return response()->json($response);
    }

    public function county_by_Id($id)
    {
        $county = County::where(['id' => $id])->get()->makeHidden(['created_by', 'status', 'created_at', 'updated_at']);

        if ($county->count() > 0) {
            $response = array('status' => 200, 'data' => $county);
        } else {
            $response = array('status' => 500, 'msg' => 'No Record Found');
        }

        return response()->json($response);
    }

    public function get_price(Request $request, $product_id, $county_id, $point_id)
    {
        $price = Product_variation::select('price')->where(['product_id' => $product_id, 'counties_id' => $county_id, 'pickup_point_id' => $point_id])->first();

        if ($price->count() > 0) {
            $response = array('status' => 200, 'data' => $price);
        } else {
            $response = array('status' => 500, 'msg' => 'No Record Found');
        }

        return response()->json($response);
    }

    public function book_product(Request $request)
    {
        $requested_data = $request->except(['_token']);
        $request->validate(
            [
                'product_id' => 'required|string',
                'booking_date' => 'required|date',
                'county_id' => 'required|string',
                'pickup_id' => 'required|string',
                'event_id' => 'required|string',
                'created_by' => 'required|string',
                'booking_amount' => 'required|string',
                'no_of_seats_booked' => 'required|string',
            ],
            [
                'product_id.required'      => 'Product id is required.',
                'booking_date.required'      => 'Booking Date is required.',
                'county_id.required'      => 'County is required.',
                'pickup_id.required'      => 'Pickup Point id is required.',
                'created_by.required'      => 'Created By is required.',
                'booking_amount.required'      => 'Booking Amount is required.',
                'no_of_seats_booked.required'      => 'No of Seats Booked is required.',
            ]
        );

        try {
            $store  = new Booking();
            foreach ($requested_data as $key => $data) {
                $store->$key = $data;
            }
            $store->save();
            $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return response()->json($response);
    }

    public function product_detail(Request $request, $id)
    {
        $result =  Product::find($id);

        $result->price =  $result->price;

        $result->image = asset('uploads/event_image') . '/' . $result->image;

        $result->date_concert = explode(',', $result->date_concert);;

        // $counties = explode(',', $result->counties_id);

        // $pickup_point = explode(',', $result->pickup_point_id);

        // $county_arr = array();

        // $pickup_arr = array();

        // foreach ($counties as $key => $value) {
        //     $county_arr[] = County::select('id', 'name')->find($value);
        // }

        // foreach ($pickup_point as $key => $value) {
        //     $pickup_arr[] = Pick_Point::select('id', 'name')->find($value);
        // }

        $result->counties = County::select('id', 'name')->get();

        $result->pickup_point = Pick_Point::select('id', 'counties_id', 'name')->get();


        if ($result) {
            $response = array('status' => 200, 'result' => $result);
        } else {
            $response = array('status' => 400, 'msg' => 'Something went wrong...!');
        }
        return response()->json($response);
    }
}
