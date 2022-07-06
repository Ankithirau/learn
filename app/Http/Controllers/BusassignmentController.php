<?php

namespace App\Http\Controllers;

use App\Models\Bus_schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusassignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $requested_data = $request->except(['_token', '_method']);

        $request->validate(
            [
                'route_name.*' => 'required|string',
                'date_concert.*' => 'required|string',
                'buses.*' => 'required|string',
            ],
            [
                'route_name.*.required'      => 'Route Name is required.',
                'date_concert.*.required'      => 'Concert Date is required.',
                'buses.*.required' => 'Bus Number is required.'
            ]
        );
        $route = $request->route_name;
        $date_concert = $request->date_concert;
        $county = $request->counties_id;
        $pickup = $request->pickup_point_id;
        $seat_count = $request->seat_count;
        $buses = $request->buses;

        for ($i = 0; $i < count($date_concert); $i++) {
            $route_name = $route[$i];
            $products = $request->product_id;
            $date = $date_concert[$i];
            $bus = $buses[$i];
            $counties = $county[$i];
            $pickup_point = $pickup[$i];
            $seat = $seat_count[$i];

            $bus_schedule_exist = Bus_schedule::where(['product_id' => $products, 'pickup_point_id' => $pickup_point, 'schedule_date' => $date])->first();

            $data_array = array(
                'route_name' => $route_name,
                'booked_seat' => $seat,
                'schedule_date' => $date,
                'pickup_point_id' => $pickup_point,
                'product_id' => $products,
                'bus_id' => $bus
            );

            if (!$bus_schedule_exist) {
                $data_array['created_by'] = Auth::user()->id;
                Bus_schedule::insert($data_array);
            } else {
                Bus_schedule::where('id', $bus_schedule_exist->id)->update($data_array);
            }
        }

        $response = array('status' => 200, 'redirect' => true, 'url' => url('product'), 'msg' => 'Data saved successfully...!');

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

    public function add_schedule(Request $request, $id)
    {
        $requested_data = $request->except(['_token', '_method']);

        // dd($request);

        if (empty($request->get('route_name'))) {
            $response = array('status' => 400, 'pickup_id' => $request->get('pickup_point_id'), 'route_name' => 'Route Name is required.');
            return json_encode($response);
        }

        if (empty($request->get('schedule_date'))) {
            $response = array('status' => 400, 'pickup_id' => $request->get('pickup_point_id'), 'date_concert' => 'Concert Date is required.');
            return json_encode($response);
        }

        if (empty($request->get('buses'))) {
            $response = array('status' => 400, 'pickup_id' => $request->get('pickup_point_id'), 'buses' => $request->get('buses'), 'buses' => 'Bus Number is required.');
            return json_encode($response);
        }

        $record = Bus_schedule::find($id);

        if (empty($record)) {

            $store = new Bus_schedule;

            $store->route_name = $request->get('route_name');

            $store->booked_seat = $request->get('booked_seat');

            $store->schedule_date = $request->get('schedule_date');

            $store->pickup_point_id = $request->get('pickup_point_id');

            $store->product_id = $request->get('product_id');

            $store->bus_id = $request->get('buses');

            $store->created_by = Auth::user()->id;

            $store->save();
        } else {

            $record->route_name = $request->get('route_name');

            $record->bus_id = $request->get('buses');

            $record->schedule_date = $request->get('schedule_date');

            $record->save();
        }

        if (!empty($record) || !empty($store)) {
            $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        } else {
            $response = array('status' => 500, 'msg' => "");
        }

        return json_encode($response);
    }
}
