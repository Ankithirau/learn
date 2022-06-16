<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\County;
use App\Models\Event;
use App\Models\Pick_Point;
use App\Models\Product;
use App\Models\Product_variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Product::orderBy('id', 'DESC')->get();

        return view("product.index", compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $points = Pick_Point::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $county = County::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $events = Event::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $category = Category::where(['status' => 1])->orderBy('id', 'DESC')->get();

        return view("product.create", compact('points', 'county', 'events', 'category'));
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
                'name' => 'required|string',
                'price' => 'required|string',
                'description' => 'required|string',
                'shortdesc' => 'required|string',
                'counties_id' => 'required',
                'status' => 'required',
                'sku' => 'required|string',
                'pick_point_id' => 'required',
                'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500',
                'date_concert' => 'required',
                'event_id' => 'required',
                'category_id' => 'required',
                'check_in_per_ticket' => 'required',
                'meta_title' => 'required|string',
                'meta_tag' => 'required|string',
                'meta_desc' => 'required|string',
            ],
            [
                'pick_point_id.required'    => 'The Pickup Point is required.',
                'counties_id.required'    => 'The Counties is required.',
                'event_id.required'    => 'The Event is required.',
                'category_id.required'    => 'The Category is required.',
                'check_in_per_ticket.required'    => 'The Check-ins per ticket is required.',
                'date_concert.required'      => 'The Date of concert is required.',
                'meta_title.required' => 'Meta Title is required.',
                'meta_tag.required' => 'Meta Tag is required.',
                'meta_desc.required' => 'Meta Description is required.',
            ]
        );

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $request->image->extension();
            $path = public_path() . '/uploads/event_image';
            $file->move($path, $filename);
        }

        try {
            $store  = new Product();
            $store->name = $requested_data['name'];
            $store->price = $requested_data['price'];
            $store->description = $requested_data['description'];
            $store->shortdesc = $requested_data['shortdesc'];
            $store->counties_id = implode(', ', $requested_data['counties_id']);
            $store->pickup_point_id = implode(', ', $requested_data['pick_point_id']);
            $store->status = $requested_data['status'];
            $store->sku = $requested_data['sku'];
            $store->check_ins_per_ticket = $requested_data['check_in_per_ticket'];
            $store->allow_ticket_check_out = $requested_data['allow_ticket_check_out'];
            $store->date_concert = $requested_data['date_concert'];
            $store->event_id = $requested_data['event_id'];
            $store->category_id = $requested_data['category_id'];
            $store->meta_title = $requested_data['meta_title'];
            $store->meta_tag = $requested_data['meta_tag'];
            $store->meta_desc = $requested_data['meta_desc'];
            $store->image = $filename;
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
        $result = Product::find($id);

        $points = Pick_Point::where(['id' => $id, 'status' => 1])->orderBy('id', 'DESC')->get();

        $county = County::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $events = Event::where(['id' => $result->event_id])->orderBy('id', 'DESC')->get();

        $category = Category::where(['status' => 1])->orderBy('id', 'DESC')->get();

        return view("product.view", compact('result', 'points', 'county', 'events', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Product::find($id);

        $pickup_points = Pick_Point::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $counties = County::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $events = Event::where(['status' => 1])->orderBy('id', 'DESC')->get();

        $categories = Category::where(['status' => 1])->where('parent_id', '=', null)->orderBy('id', 'DESC')->get();

        // $arr_point = explode(',', $result->pickup_point_id);

        // $arr_county = explode(',', $result->counties_id);

        // $arr_category = explode(',', $result->category_id);

        // foreach ($arr_point as $key => $value) {

        //     $pickup_point[] = Pick_Point::where(['id' => $value])->get();
        // }



        // foreach ($arr_county as $key => $value) {
        //     $county[] = County::where(['id' => $value])->get();
        // }



        // foreach ($arr_category as $key => $value) {
        //     $category[] = Category::where(['id' => $value])->get();
        // }


        return view('product.edit', compact('result', 'pickup_points',   'counties', 'events',  'categories'));
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
                'name' => 'required|string',
                'price' => 'required|string',
                'description' => 'required|string',
                'shortdesc' => 'required|string',
                'counties_id' => 'required',
                'status' => 'required',
                'sku' => 'required|string',
                'pick_point_id' => 'required',
                'date_concert' => 'required',
                'event_id' => 'required',
                'category_id' => 'required',
                'check_ins_per_ticket' => 'required',
                'meta_title' => 'required|string',
                'meta_tag' => 'required|string',
                'meta_desc' => 'required|string',
            ],
            [
                'pick_point_id.required'    => 'The Pickup Point is required.',
                'counties_id.required'    => 'The Counties is required.',
                'event_id.required'    => 'The Event is required.',
                'category_id.required'    => 'The Category is required.',
                'check_in_per_ticket.required'    => 'The Check-ins per ticket is required.',
                'date_concert.required'      => 'The Date of concert is required.',
                'meta_title.required' => 'Meta Title is required.',
                'meta_tag.required' => 'Meta Tag is required.',
                'meta_desc.required' => 'Meta Description is required.',
            ]
        );

        $store = Product::find($id);

        try {
            $store->name = $requested_data['name'];
            $store->price = $requested_data['price'];
            $store->description = $requested_data['description'];
            $store->shortdesc = $requested_data['shortdesc'];
            $store->counties_id = implode(', ', $requested_data['counties_id']);
            $store->pickup_point_id = implode(', ', $requested_data['pick_point_id']);
            $store->status = $requested_data['status'];
            $store->sku = $requested_data['sku'];
            $store->check_ins_per_ticket = $requested_data['check_ins_per_ticket'];
            $store->allow_ticket_check_out = $requested_data['allow_ticket_check_out'];
            $store->date_concert = $requested_data['date_concert'];
            $store->event_id = $requested_data['event_id'];
            $store->category_id = $requested_data['category_id'];
            $store->meta_title = $requested_data['meta_title'];
            $store->meta_tag = $requested_data['meta_tag'];
            $store->meta_desc = $requested_data['meta_desc'];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $request->image->extension();
                $path = public_path() . '/uploads/event_image';
                $file->move($path, $filename);
                $store->image = $filename;
            } else {
                $store->image = $store->image;
            }

            $store->created_by = Auth::user()->id;

            $store->save();
            $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => $th->getMessage());
        }
        return json_encode($response);

        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete($id);
        return json_encode([
            'status' => 200,
            'msg' => 'Record deleted successfully!'
        ]);
    }

    public function status($id)
    {
        try {
            $update  = Product::find($id);
            $update->status = !$update->status;
            $update->save();
            $response = array('status' => 200, 'msg' => 'Status updated successfully...!');
        } catch (\Throwable $th) {
            $response = array('status' => 500, 'msg' => 'Something went wrong...!');
        }
        return json_encode($response);
    }

    public function product_variation(Request $request, $id)
    {

        $product = Product::find($id);
        $date_concert = explode(',', $product->date_concert);
        $response = [];
        foreach ($date_concert as $concert) {
            $counties_id = explode(',', $product->counties_id);
            foreach ($counties_id as $key => $value) {
                $counties = County::where(['id' => $value])->get();
                foreach ($counties as $key => $county) {
                    $pick = Pick_Point::where(['counties_id' => $county->id])->get();
                    // $variation[] = Product_variation::where(['counties_id' => $county->id, 'product_id' => $id,'produ'])->get();
                    $result[] = array('date_concert' => $concert, 'county' => $county, 'pick_point' => $pick, 'product' => $product);
                }
            }
        }

        // return response()->json($result);
        return view('product.variation', compact('result'));
    }

    public function add_variation(Request $request, $id)
    {
        // dd($id);
        $requested_data = $request->except(['_token', '_method']);
        if (empty($request->get('price'))) {
            $response = array('status' => 400, 'pickup_id' => $request->get('pickup_id'), 'price' => 'Price is required.');
            return json_encode($response);
        }
        // die();
        // try {

        $store = Product_variation::firstOrNew(array('id' => $id));

        // $store->date_concert = implode(', ', $request->get('date'));

        $store->date_concert = $request->get('date');

        // $store->price = $requested_data['price'];

        $store->price = $request->get('price');

        // $store->counties_id = implode(', ', $request->get('county_id'));

        $store->counties_id = $request->get('county_id');

        // $store->pickup_point_id = implode(', ', $request->get('pickup_id'));

        $store->pickup_point_id = $request->get('pickup_id');

        $store->product_id = $request->get('product');

        $store->created_by = Auth::user()->id;

        $store->save();

        $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        // } catch (\Throwable $th) {
        $response = array('status' => 500, 'msg' => "");
        // }
        return json_encode($response);
    }

    public function add_variation_by_form(Request $request)
    {
        $requested_data = $request->except(['_token', '_method']);

        $request->validate(
            [
                'price' => 'required'
            ],
            [
                'price.required'    => 'The price is required.'
            ]
        );
        $dates = $request->date;
        $products = $request->product_id;
        $prices = $request->price;
        $counties = $request->county_id;
        $pickups = $request->pickup_id;
        for ($i = 0; $i < count($dates); $i++) {
            $date = $dates[$i];
            $product_id = $products[$i];
            $price = $prices[$i];
            $counties_id = $counties[$i];
            $pickup_id = $pickups[$i];
            $variation_exist = Product_variation::where(['product_id' => $product_id, 'counties_id' => $counties_id, 'pickup_point_id' => $pickup_id])->first();
            $data_array = array(
                'date_concert' => $date,
                'product_id' => $product_id,
                'price' => $price,
                'counties_id' => $counties_id,
                'pickup_point_id' => $product_id
            );
            if (!$variation_exist) {
                $data_array['created_by'] = Auth::user()->id;
                Product_variation::insert($data_array);
            } else {
                Product_variation::where('id', $variation_exist->id)->update($data_array);
            }
        }

        // if (empty($request->get('price'))) {
        //     $response = array('status' => 400, 'pickup_id' => $request->get('pickup_id'), 'price' => 'Price is required.');
        //     return json_encode($response);
        // }
        // die();
        // try {
        // $store  = new Product_variation();

        // for ($i=0; $i <count ; $i++) { 
        //     # code...
        // }

        // $store->date_concert = implode(', ', $request->get('date'));

        // // $store->date_concert = $request->get('date');

        // // $store->price = $requested_data['price'];

        // $store->price = $request->get('price');

        // $store->counties_id = implode(', ', $request->get('county_id'));

        // // $store->counties_id = $request->get('county_id');

        // $store->pickup_point_id = implode(', ', $request->get('pickup_id'));

        // // $store->pickup_point_id = $request->get('pickup_id');

        // $store->product_id = implode(', ', $request->get('product'));

        // $store->created_by = Auth::user()->id;

        // $store->save();

        $response = array('status' => 200, 'msg' => 'Data saved successfully...!');
        // } catch (\Throwable $th) {
        //     $response = array('status' => 500, 'msg' => $th);
        // }
        return json_encode($response);
    }
}
