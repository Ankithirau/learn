<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::where('status', 1)->orderBy('name', 'asc')->get();
        $results =  Place::select('places.*', 'states.name as state_name')
            ->join('states', 'places.state_id', '=', 'states.id')
            ->orderBy('id', 'desc')->get();
        return view('places.index', compact('results', 'states'));
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
                'state_id' => 'required',
                'name' => 'required',
            ],
            [
                'state_id.required'    => 'The state field is required.',
                'name.required'      => 'The place field is required.',
            ]
        );
        try {
            $store  = new Place();
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
        $result =  Place::find($id);
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
                'state_id' => 'required',
                'name' => 'required',
            ],
            [
                'state_id.required'    => 'The state field is required.',
                'name.required'      => 'The place field is required.',
            ]
        );
        try {
            $update  = Place::find($id);
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
        Place::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }
    //Update status

    public function status($id)
    {
        try {
            $update  = Place::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return json_encode($response);
    }
    //Get Place list via ajax
    public function get_Place(Request $request)
    {
        $results = Place::where(['state_id' => $request->id, 'status' => 1])->get();
        return json_encode($results);
    }
}
