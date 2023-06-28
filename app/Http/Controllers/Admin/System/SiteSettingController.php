<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\System\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SiteSetting::latest();
        $query->whereLike($request->field_name, $request->value);

        $datas = $query->paginate(10);

        return new Resource($datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.admin_app');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conf = SiteSetting::first();
        $data = $request->all();
        $file1 = $request->file('logo');
        $file2 = $request->file('logo_small');
        $file3 = $request->file('favicon');

        if (! empty($conf)) {
            $this->validateCheck($request);
            // LOGO UPLOAD
            if (! empty($file1)) {
                $data['logo'] = $this->upload($file1, 'conf', $conf->logo);
            } else {
                $data['logo'] = $this->oldFile($conf->logo);
            }

            // LOGO SMALL UPLOAD
            if (! empty($file2)) {
                $data['logo_small'] = $this->upload($file2, 'conf', $conf->logo_small);
            } else {
                $data['logo_small'] = $this->oldFile($conf->logo_small);
            }

            // FAVICON UPLOAD
            if (! empty($file3)) {
                $data['favicon'] = $this->upload($file3, 'conf', $conf->favicon);
            } else {
                $data['favicon'] = $this->oldFile($conf->favicon);
            }

            $conf->update($data);
        } else {
            $this->validateCheck($request);
            if (! empty($file1)) {
                $data['logo'] = $this->upload($file1, 'conf');
            }
            if (! empty($file2)) {
                $data['logo_small'] = $this->upload($file2, 'conf');
            }
            if (! empty($file3)) {
                $data['favicon'] = $this->upload($file3, 'conf');
            }

            SiteSetting::create($data);
        }
        Artisan::call('optimize:clear');

        $type = ! empty($content) ? 'Update' : 'Create';

        return response()->json(['message' => $type.' Successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\SiteSetting  $SiteSetting
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SiteSetting $siteSetting)
    {
        if ($request->format() == 'html') {
            return view('layouts.admin_app');
        }

        return SiteSetting::first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\SiteSetting  $SiteSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSetting $siteSetting)
    {
        return view('layouts.admin_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Model\SiteSetting  $SiteSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSetting $siteSetting)
    {
        return view('layouts.admin_app');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\SiteSetting  $SiteSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSetting $siteSetting)
    {
        $old1 = $this->oldFile($siteSetting->logo);
        $old2 = $this->oldFile($siteSetting->logo_small);
        $old3 = $this->oldFile($siteSetting->favicon);

        if (Storage::disk('public')->exists($old1)) {
            Storage::delete($old1);
        }

        if (Storage::disk('public')->exists($old2)) {
            Storage::delete($old2);
        }

        if (Storage::disk('public')->exists($old3)) {
            Storage::delete($old3);
        }

        if ($siteSetting->delete()) {
            return response()->json(['message' => 'Delete Successfully!'], 200);
        } else {
            return response()->json(['message' => 'Delete Unsuccessfully!'], 200);
        }
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $id = null)
    {
        return $request->validate([
            'title' => 'required|string|min:0|max:191',
            'short_title' => 'required|string|min:0|max:191',
            'logo' => 'nullable|mimes:jpeg,jpg,png',
            'logo_small' => 'nullable|mimes:jpeg,jpg,png',
            'favicon' => 'nullable|mimes:jpeg,jpg,png',
        ]);
    }
}
