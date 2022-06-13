<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = User::where('type', '!=', 'Admin')->where('type', '!=', 'User')->orderBy('id', 'DESC')->get();

        return view("operator.index", compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("operator.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $requested_data = $request->except(['_token', '_method']);
        $request->validate(
            [
                'name' => ['required', 'string', Rule::unique('users', 'name')],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|string',
                'mobile' => 'required|integer',
                'status' => 'required|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'pincode' => 'required|integer',
            ],
            [
                'name.required'      => 'Operator Name field is required.',
            ]
        );
        try {
            $store  = new User();
            foreach ($requested_data as $key => $data) {
                $store->$key = $data;
            }
            $store->type = 'Operator';
            $store->password = Hash::make($request->password);
            $store->save();
            $response = array('status' => 200, 'redirect' => true, 'url' => url('operator'), 'msg' => 'Data saved successfully...!');
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
        $result =  User::find($id);

        return view("operator.view", compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result =  User::find($id);

        return view("operator.edit", compact('result'));
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

        // dd($request);
        $requested_data = $request->except(['_token', '_method']);
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'mobile' => 'required|integer',
                'status' => 'required|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'pincode' => 'required|integer',
            ],
            [
                'name.required'      => 'Operator Name field is required.',
            ]
        );
        try {
            $update  = User::find($id);
            foreach ($requested_data as $key => $data) {
                $update->$key = $data;
            }
            $update->password = Hash::make($request->password);
            $update->save();
            $response = array('status' => 200, 'redirect' => true, 'url' => url('operator'), 'msg' => 'Data updated successfully...!');
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
        User::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }

    public function status($id)
    {
        try {
            $update  = User::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th);
        }
        return json_encode($response);
    }
}
