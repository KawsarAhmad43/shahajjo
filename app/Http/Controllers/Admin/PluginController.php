<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PluginHelper;
use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\Resource;
use App\Models\Plugin;
use Exception;
use Illuminate\Http\Request;
use Storage;

class PluginController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Plugin::latest();
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
        $file = $request->file('zip_file');
        $file->move(public_path('/'), $file->getClientOriginalName());

        return PluginHelper::moveFileTodirectory($request);
        if ($this->validateCheck($request)) {
            try {
                $data = $request->all();
                // push the insert text
                if (! empty($request->file('zip_file'))) {
                    $data['zip_file'] = $this->upload($request->zip_file, 'plugin');
                }$res = Plugin::create($data);

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
    public function show(Request $request, Plugin $plugin)
    {
        if ($request->format() == 'html') {
            return view('layouts.backend_app');
        }

        return $plugin;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Plugin $plugin)
    {
        return view('layouts.backend_app');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plugin $plugin)
    {
        if ($this->validateCheck($request, $plugin->id)) {
            try {
                $data = $request->all();
                // push the update text
                if (! empty($request->file('zip_file'))) {
                    $oldFile = $this->oldFile($model->zip_file);
                    Storage::delete($oldFile);
                    $data['zip_file'] = $this->upload($request->zip_file, 'plugin');
                }$plugin->fill($data)->save();

                return $this->responseReturn('update', $plugin);
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
    public function destroy(Plugin $plugin)
    {
        $res = $plugin->delete();

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
