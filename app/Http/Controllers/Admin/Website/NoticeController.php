<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Website\Notice;
use Exception;
use Illuminate\Http\Request;
use Storage;

class NoticeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Notice::latest();
        $query->whereLike($request->field_name, $request->value);
        $query->whereAny('status', $request->status);

        // Notice date wise search.
        $startDate = $request->from_date;
        $endDate = $request->to_date;

        if (! empty($startDate) || ! empty($endDate)) {
            $startDate = $request->from_date ?? '1900-01-01';
            $endDate = $request->to_date ?? $startDate;
            $query->whereBetween('notice_date', [$startDate, $endDate]);
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
            try {
                $data = $request->all();
                // push the insert text
                if (! empty($request->file('file'))) {
                    $data['file'] = $this->upload($request->file, 'notice');
                }

                $res = Notice::create($data);

                return $this->responseReturn('create', $res);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        return Notice::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->validateCheck($request, $id)) {
            try {
                $notice = Notice::find($id);
                $data = $request->all();
                // push the update text
                if (! empty($request->file('file'))) {
                    $oldFile = $this->oldFile($notice->file);
                    Storage::delete($oldFile);
                    $data['file'] = $this->upload($request->file, 'notice');
                }
                $notice->fill($data)->save();

                return $this->responseReturn('update', $notice);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::find($id);
        if (! isEmpty($notice->file)) {
            $oldFile = $this->oldFile($notice->file);
            Storage::delete($oldFile);
        }
        $res = $notice->delete();

        return $this->responseReturn('delete', $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return $request->validate([
            'type' => 'required|max:191',
            'title' => 'required|max:191',
            'notice_date' => 'required',
            'status' => 'required',
            'file' => 'mimes:pdf|max:10000',
            'description' => 'max:2000',
        ], []);
    }
}
