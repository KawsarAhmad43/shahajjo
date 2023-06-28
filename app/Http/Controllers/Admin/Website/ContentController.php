<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\System\Menu;
use App\Models\Website\Content\Content;
use App\Models\Website\Content\ContentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends BaseController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Content::latest();
        $query->whereLike($request->field_name, $request->value);
        $query->whereAny('status', $request->status);

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
    public function create($slug = null)
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
        $file = $request->image_data;
        $content = Content::where('slug', $request->slug)->first();

        if (empty($request->slug)) {
            return response()->json(['error' => 'Slug is Missing!'], 200);
        }

        if (! empty($content)) {
            if (! empty($file)) {
                $data['image'] = $this->upload($file, 'content', $content->image, $base64 = true);
            } else {
                $data['image'] = $this->oldFile($content->image);
            }

            $content->update($data);
        } else {
            if (! empty($file)) {
                $data['image'] = $this->upload($file, 'content', null, $base64 = true);
            }

            $store = Content::create($data);
        }

        $type = ! empty($content) ? 'update' : 'create';
        $res = $type == 'update' ? $content : $store;

        return $this->responseReturn($type, $res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeFile(Request $request, Content $content)
    {
        if ($this->validateCheck($request)) {
            $data = $request->all();
            $file = $request->file('file');
            if (! empty($file)) {
                $data['file'] = $this->upload($file, 'content-file');
            }

            $content->contentFiles()->create($data);

            return response()->json(['message' => 'Create Successfully!'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        return Content::with('contentFiles')->where('slug', $slug)->first() ??
            ['status' => 'active'];
    }

    public function edit(Content $Content)
    {
        return view('layouts.backend_app');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = Content::find($id);
        if (! empty($content)) {
            $contentFiles = ContentFile::where('content_id', $content->id)->get();

            foreach ($contentFiles ?? [] as $contentFile) {
                $old = $this->oldFile($contentFile->file);
                if (Storage::disk('public')->exists($old)) {
                    Storage::delete($old);
                }
                $contentFile->delete();
            }

            $old = $this->oldFile($content->image);

            if (Storage::disk('public')->exists($old)) {
                Storage::delete($old);
            }

            //$menuName = ucwords(str_replace("-", " ", $slug));
            //$menu = Menu::where('menu_name', $menuName)->first();

            $slug = $content->slug;
            $menu = Menu::where('params', $content->slug)->delete();
            $content->delete();

            return response()->json(['message' => 'Delete Successfully!'], 200);
        } else {
            return response()->json(['message' => 'Delete Unsuccessful!'], 200);
        }
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request)
    {
        return $request->validate([
            'title' => 'required',
            'file' => 'required',
        ]);
    }
}
