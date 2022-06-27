<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function get_slider()
    {
        $slider = Slider::select('title', 'photo', 'product_id')->where(['status' => 1])->get();

        foreach ($slider as $key => $item) {
            $item->photo = asset('uploads/slider') . '/' . $item->photo;
        }

        if ($slider->count() > 0) {
            $response = array('status' => 200, 'data' => $slider);
        } else {
            $response = array('status' => 500, 'msg' => 'No Record Found');
        }

        return response()->json($response, 200);
    }
}
