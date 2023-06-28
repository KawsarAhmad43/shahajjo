<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Storage;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Profile::latest();
        $query->whereLike($request->field_name, $request->value);

        $datas = $query->paginate($request->pagination);

        return new Resource($datas);
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
                    $data['file'] = $this->upload($request->file, 'profile');
                }
                if (! empty($request->file('image'))) {
                    $data['image'] = $this->upload($request->corp, 'corp', $old = null, $base64 = true);
                }
                $res = Profile::create($data);

                return $this->responseReturn('create', $res);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Profile $profile)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        return $profile;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        // dd( $request );
        if ($this->validateCheck($request, $profile->id)) {
            try {
                $data = $request->all();
                // push the update text
                if (! empty($request->file('file'))) {
                    $oldFile = $this->oldFile($profile->file);
                    Storage::delete($oldFile);
                    $data['file'] = $this->upload($request->file, 'profile');
                }

                if (! empty($request->file('image'))) {
                    $oldFile = $this->oldFile($profile->image);
                    Storage::delete($oldFile);
                    $data['image'] = $this->upload($request->image, 'corp', null, true);
                }

                if (! empty($request->corp)) {
                    $oldFile = $this->oldFile($profile->image);
                    Storage::delete($oldFile);
                    $data['corp'] = $this->upload($request->corp, 'corp', null, true);
                }

                $profile->fill($data)->save();

                return $this->responseReturn('update', $profile);
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $res = $profile->delete();

        return $this->responseReturn('delete', $res);
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return true;

        return $request->validate([
            //ex: 'name' => 'required|email|nullable|date|string|min:0|max:191',
        ], [
            //ex: 'name' => "This name is required" (custom message)
        ]);
    }
}
