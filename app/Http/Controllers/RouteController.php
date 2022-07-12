<?php

namespace App\Http\Controllers;

use App\Models\Pick_Point;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = Pick_Point::where(['status' => 1])->orderBy('name', 'DESC')->get();

        $results =Route::orderBy('route_name', 'DESC')->get();

        return view('route.index',compact('points','results'));
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
        $requested_data = $request->except(['_token']);

        $request->validate(
            [
                'route_name' => ['required', 'string', Rule::unique('routes', 'route_name')],
                'pickup_point_id' => 'required|array',
            ],
            [
                'pickup_point_id.required'      => 'Pick Up Location is required.',
            ]
        );
        try {
            $store  = new Route;
            $store->route_name=$request->route_name; 
            $store->pickup_point_id=implode(", ", $request->pickup_point_id); 
            $store->created_by = Auth::user()->id;
            $store->save();
            $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th->getMessage());
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
}
