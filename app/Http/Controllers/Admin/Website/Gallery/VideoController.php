<?php
/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideoController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Video::with('album')->whereHas('album', function ($query) use ($request) {
            $query->whereLike('name', $request->value);
        })->oldest('sorting');

        $query->whereAny('status', $request->status);

        if (! empty($request->album_id)) {
            $query->whereAny('album_id', $request->album_id);
        }

        if ($request->field_name !== 'album_name') {
            $query->whereLike($request->field_name, $request->value);
        }

        if ($request->allData) {
            return $query->get();
        } else {
            $datas = $query->paginate($request->pagination);

            return new Resource($datas);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend_app');
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
            $data = $request->except('thumbnail');

            $thumbnail = $request->thumbnail;

            if (! empty($thumbnail)) {
                $data['thumbnail'] = $this->upload($thumbnail, 'video', null, $base64 = true);
            }

            $res = Video::create($data);

            return $this->responseReturn('create', $res);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Video $video)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        return $video;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        if ($this->validateCheck($request)) {
            Cache::forget('website_cache');

            $data = $request->except('thumbnail');
            $thumbnail = $request->thumbnail;

            if ($video->thumbnail !== $thumbnail) {
                $data['thumbnail'] = $this->upload($thumbnail, 'video', null, $base64 = true);
            } else {
                $data['thumbnail'] = $this->oldFile($video->thumbnail);
            }

            $video->update($data);

            return $this->responseReturn('update', $video);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        Cache::forget('website_cache');

        $res = $video->delete();

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
            'sorting' => 'required',
            'status' => 'required',
            'thumbnail' => 'required',
            'title' => 'required',
            'url' => 'required|url',
            'album_id' => 'required',
        ]);
    }
}
