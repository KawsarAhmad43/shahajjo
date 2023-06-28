<?php

namespace App\Http\Controllers\Admin\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Models\SliderDetails;
use App\Models\Website\Gallery\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SliderDetailsController extends BaseController
{
    /**
     * Create page of slider details
     *
     * @return bool
     */
    public function create()
    {
        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            Cache::forget('website_cache');
            $slider = Slider::where('id', $request->slider_id)->firstOrFail();

            if (! empty($slider)) {
                $count = SliderDetails::where('slider_id', $slider->id)->count();

                if ($slider->max_image <= $count) {

                    return response()->json([
                        'message' => 'Sorry, The maximum number of images for this slider has been reached.',
                    ], 203);
                }
            }

            $path = 'slider/'.$slider->slug;
            $data = $request->except('image');
            $image = $request->image;

            if (! empty($image)) {
                $data['image'] = $image; // $this->upload($file, $path, null, $base64 = true);
            }

            $res = SliderDetails::create($data);

            return $this->responseReturn('create', $res);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->validateCheck($request)) {
            Cache::forget('website_cache');
            $slider = SliderDetails::where('id', $id)->firstOrFail();
            $data = $request->all();
            $image = $request->image;

            if ($slider->image !== $image) {
                $data['image'] = $this->upload($image, 'slider', $slider->image, $base64 = true);
            } else {
                $data['image'] = $slider->image;
            }

            $slider->update($data);

            return $this->responseReturn('update', $slider);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        $details = SliderDetails::query()
            ->where('id', $id)
            ->firstOrFail();

        return $details;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $details = SliderDetails::where('id', $id)->first();
        $res = $details->delete();

        return $this->responseReturn('delete', $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request)
    {
        return $request->validate([
            'image' => 'required',
            'status' => 'required',
            'sorting' => 'required',
            'button_name' => 'max:200',
        ]);
    }

    /**
     * Get slider height and width
     *
     * @param [type] $id
     * @return array
     */
    public function heightWidth($id)
    {
        $slider = Slider::query()
            ->where('id', $id)
            ->FirstOrFail();

        return [
            'height' => $slider->height,
            'width' => $slider->width,
        ];
    }
}
