<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = News::latest();
        $query->whereLike($request->field_name, $request->value);
        $query->whereAny('status', $request->status);

        // News date wise search.
        $startDate = $request->from_date;
        $endDate = $request->to_date;

        if (! empty($startDate) || ! empty($endDate)) {
            $startDate = $request->from_date ?? '1900-01-01';
            $endDate = $request->to_date ?? $startDate;
            $query->whereBetween('date', [$startDate, $endDate]);
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
            $data = $request->all();
            $image = $request->image;

            if (! empty($image)) {
                $data['image'] = $this->upload($image, 'news', null, $base64 = true);
            }

            $res = News::create($data);

            return $this->responseReturn('create', $res);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        return News::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        if ($this->validateCheck($request)) {
            $data = $request->all();
            $image = $request->image;

            if ($news->image !== $image) {
                $data['image'] = $this->upload($image, 'news', $news->image, $base64 = true);
            } else {
                $data['image'] = $this->oldFile($news->image);
            }

            $news->update($data);

            return $this->responseReturn('update', $news);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::where('id', $id)->firstOrFail();

        $old = $this->oldFile($news->image);
        if (Storage::disk('public')->exists($old)) {
            Storage::delete($old);
        }

        $res = $news->delete();

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
            'date' => 'required',
            'image' => 'required',
            'title' => 'required|max:200',
        ]);
    }
}
