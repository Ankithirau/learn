<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\Bus_schedule;
use App\Models\County;
use App\Models\Pick_Point;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Operator;

use function PHPUnit\Framework\returnSelf;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Bus::orderBy('id', 'DESC')->get();

        $operators = User::where(['status' => 1, 'type' => 'Operator'])->orderBy('id', 'DESC')->get();

        return view("bus.index", compact('results', 'operators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request, $id)
    {

        $products = Product::select('pickup_point_id', 'booked_seat', 'date_concert')->where(['id' => $id])->first();

        $buses = Bus::where('status', 1)->get();

        $point = explode(',', $products->pickup_point_id);

        $points = Pick_Point::select('id', 'counties_id', 'name')->whereIn('id', $point)->get();

        foreach ($points as $key => $value) {
            $points[$key]['seat_count'] = Booking::where(['product_id' => $id, 'pickup_id' => $value->id])->sum('number_of_seats');
            $county =  County::select('id', 'name')->where('id', $value->counties_id)->first();
            $points[$key]['county_name'] = $county->name;
            $points[$key]['date_concert'] = explode(',', $products->date_concert);
            $points[$key]['product_id'] = $id;
            $points[$key]['bus_assign'] = Bus_schedule::where(['product_id' => $id, 'pickup_point_id' => $value->id])->get();
        }
        return view("schedule.create", compact('buses', 'points'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $requested_data = $request->except(['_token', '_method']);

        $request->validate(
            [
                'operator_name' => 'required|string',
                'bus_number' => 'required|string',
                'bus_registration_number' => 'required|string',
                'bus_type' => 'required|string',
                'capacity' => 'required|integer',
                'status' => 'required|string',
            ],
            [
                'operator_name.required'      => 'Operator Name is required.',
                'bus_number.required'      => 'Bus Number is required.',
                'bus_registration_number.required' => 'Bus Registration Number is required.',
                'bus_type.required'      => 'Bus type is required.',
                'capacity.required'      => 'Bus Capacity is required.'
            ]
        );
        try {
            $store  = new Bus();
            foreach ($requested_data as $key => $data) {
                $store->$key = $data;
            }
            $store->created_by = Auth::user()->id;
            $store->save();
            $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
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
        $result =  Bus::find($id);
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
                'operator_name' => 'required|string',
                'bus_number' => 'required|string',
                'bus_registration_number' => 'required|string',
                'bus_type' => 'required|string',
                'capacity' => 'required|integer',
                'status' => 'required|string',
            ],
            [
                'operator_name.required'      => 'Operator Name is required.',
                'bus_number.required'      => 'Bus Number is required.',
                'bus_registration_number.required' => 'Bus Registration Number is required.',
                'bus_type.required'      => 'Bus type is required.',
                'capacity.required'      => 'Bus Capacity is required.'
            ]
        );
        try {
            $update  = Bus::find($id);
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
        Bus::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }

    public function status($id)
    {
        try {
            $update  = Bus::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return json_encode($response);
    }
}
