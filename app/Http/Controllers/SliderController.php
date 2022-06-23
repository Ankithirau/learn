<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::select('id', 'name')->where(['status' => 1])->orderBy('name', 'desc')->get();

        $slider = Slider::select('id', 'title', 'photo', 'product_id')->orderBy('id', 'desc')->get();

        return view('slider.index', compact('products', 'slider'));
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
                'title' => 'required|string',
                'product_id' => 'required|string',
                'photo'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            ],
            [
                'title.required'      => 'Slider title is required.',
                'product_id.required'      => 'Event field is required.',
                'photo.required'      => 'Slider image is required.',
            ]
        );
        try {
            $store  = new Slider();
            foreach ($requested_data as $key => $data) {
                $store->$key = $data;
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $request->photo->extension();
                $path = public_path() . '/uploads/slider';
                $file->move($path, $filename);
            }
            $store->photo = $filename;
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
        $result =  Slider::select('id', 'title', 'product_id')->find($id);
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
                'title' => 'string',
                'product_id' => 'string',
                'photo'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:500',
            ]
        );
        try {
            $update  = Slider::find($id);
            foreach ($requested_data as $key => $data) {
                $update->$key = $data;
            }
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $request->photo->extension();
                $path = public_path() . '/uploads/slider';
                $file->move($path, $filename);
                $update->photo = $filename;
            } else {
                $update->photo = $update->photo;
            }
            $update->created_by = Auth::user()->id;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Data updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th);
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
        Slider::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }

    public function status($id)
    {
        try {
            $update  = Slider::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th->getMessage());
        }
        return json_encode($response);
    }
}
