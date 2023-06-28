<?php
/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin\Website\Gallery;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Gallery\Album;
use App\Models\Website\Gallery\Photo;
use App\Models\Website\Gallery\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Album::oldest('sorting');
        $query->whereLike($request->field_name, $request->value);
        $query->whereAny('status', $request->status);
        $query->whereAny('type', $request->type);

        if ($request->allData) {
            $query->where('type', $request->type);

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
        $data = $request->all();
        $file = $request->image;
        if (! empty($file)) {
            $data['image'] = $this->upload($request->image, 'album', null, $base64 = true);
        }

        $res = Album::create($data);

        return $this->responseReturn('create', $res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $album = Album::find($id);

        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }
        if ($request->view != null) {
            return Photo::where('album_id', $album->id)->get();
        }

        return $album;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $data = $request->all();
        $file = $request->image;

        if (! empty($file)) {
            $data['image'] = $this->upload($request->image, 'album', $album->image, $base64 = true);
        } else {
            $data['image'] = $this->oldFile($album->image);
        }

        $album->update($data);

        return $this->responseReturn('update', $album);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = Album::where('id', $id)->firstOrFail();

        $old = $this->oldFile($album->image);
        if (Storage::disk('public')->exists($old)) {
            Storage::delete($old);
        }

        if ($album->type === 'Videos') {
            $videos = Video::where('album_id', $album->id)->get();

        // foreach ($videos as $key => $video) {
        //     $old = $this->oldFile($video->image);
        //     if (Storage::disk('public')->exists($old)) {
        //         Storage::delete($old);
        //     }
        // }
        // Video::where('album_id', $album->id)->delete();

        } else {
            $photos = Photo::where('album_id', $album->id)->get();
            foreach ($photos as $key => $photo) {
                foreach ($photo->images as $key1 => $value) {
                    // $value = json_decode( $value );
                    // return $value;
                    $old = $this->oldFile($value);
                    if (Storage::disk('public')->exists($old)) {
                        Storage::delete($old);
                    }
                }
            }
            Photo::where('album_id', $album->id)->delete();
        }

        $old = $this->oldFile($album->image);
        if (Storage::disk('public')->exists($old)) {
            Storage::delete($old);
        }

        $res = $album->delete();

        return $this->responseReturn('delete', $res);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function album($type)
    {
        return Album::oldest('sorting')
            ->where('type', $type)
            ->where('status', 'active')
            ->get(['name', 'id']);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request)
    {
        return $request->validate([
            'name' => 'required|max:200',
        ]);
    }
}
