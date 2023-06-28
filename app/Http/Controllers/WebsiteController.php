<?php

namespace App\Http\Controllers;

use App\Models\SliderDetails;
use App\Models\Website\Gallery\Slider;

class WebsiteController extends Controller
{
    public function index()
    {
        //$sliders = SliderDetails::where('slider_id',1)->get();

        return view('website.vue-web-home');
    }
}
