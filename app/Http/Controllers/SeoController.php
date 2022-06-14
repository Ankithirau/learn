<?php

namespace App\Http\Controllers;

use App\Models\Seo_settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Seo_settings::orderBy('id', 'DESC')->get();

        return view("seo.index", compact('results'));
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
        $result =  Seo_settings::find($id);
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
                'meta_title' => 'required|string',
                'meta_tag' => 'required|string',
                'meta_description' => 'required|string',
            ],
            [
                'meta_title.required'      => 'Meta title is required.',
                'meta_tag.required'      => 'Meta tag is required.',
                'meta_description.required'      => 'Meta description is required.',
            ]
        );
        try {
            $update  = Seo_settings::find($id);
            foreach ($requested_data as $key => $data) {
                $update->$key = $data;
            }
            if ($request->hasFile('meta_image')) {
                $file = $request->file('meta_image');
                $filename = time() . '.' . $request->meta_image->extension();
                $path = public_path() . '/uploads/seo_image';
                $file->move($path, $filename);
                $update->meta_image = $filename;
            } else {
                $update->meta_image = $update->meta_image;
            }

            $update->created_by = Auth::user()->id;

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
        Seo_settings::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }

    public function status($id)
    {
        try {
            $update  = Seo_settings::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th->getMessage());
        }
        return json_encode($response);
    }
}
