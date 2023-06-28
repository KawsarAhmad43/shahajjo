<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Global return the response
     *
     * @param [type] $type
     * @param [type] $res
     * @return json
     */
    public function responseReturn($type, $res = null)
    {
        if ($type == 'create') {
            $reType = $res ? 'Successfully' : 'Unsuccessfully';
            $key = $res ? 'message' : 'error';

            return response()->json([$key => "Save {$reType}!"], 201);

        } elseif ($type == 'update') {
            if ($res->wasChanged()) {
                return response()->json(['message' => 'Update Successfully!'], 201);
            }

            return response()->json(['message' => 'No data updated'], 203);

        } elseif ($type == 'delete') {
            $reType = $res ? 'Successfully' : 'Unsuccessfully';

            return response()->json(['message' => "Delete {$reType}!"], 201);
        }
    }
}
