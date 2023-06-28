<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SortingController extends Controller
{
    /**
     * Sorting your data.
     */
    public function sorting(Request $request)
    {
        if (! empty($request->model)) {
            /*-----MODLE DEFINE-----*/
            $explode = explode('-', $request->model);
            $implode = implode('\\', $explode);
            $model_name = '\\App\\Models\\'.$implode;
            $model = new $model_name;
        }
        if (! empty($model)) {
            if ($request->auto) {
                $sorting = $request->number;
                $category = $model->select('id', 'sorting')->find($request->id);

                // FOR POSITION MIN FROM PRESENT VALUE
                if ($category->sorting > $sorting) {
                    $minData = $model->where('status', 'Active')->oldest('sorting')
                        ->where('sorting', '>=', $sorting)
                        ->where('sorting', '<', $category->sorting)->get(['id', 'sorting'])->toArray();
                    $category->update(['sorting' => $sorting]);

                    foreach ($minData as $value) {
                        $sorting++;
                        $model->where('id', $value['id'])->update(['sorting' => $sorting]);
                    }
                } else {
                    // FOR POSITION MAX FROM PRESENT VALUE
                    $minData = $model->where('status', 'Active')->oldest('sorting')
                        ->where('sorting', '<=', $sorting)
                        ->where('sorting', '<=', $category->sorting);

                    $minDataMax = $model->where('status', 'Active')->oldest('sorting')
                        ->where('sorting', '<=', $sorting)
                        ->where('sorting', '>', $category->sorting)
                        ->get(['id', 'sorting'])->toArray();

                    $maxData = $model->where('status', 'Active')
                        ->where('sorting', '>', $sorting)->get(['id', 'sorting'])->toArray();

                    $count = $minData->count();
                    foreach ($minDataMax as $value) {
                        $model->where('id', $value['id'])->update(['sorting' => $count]);
                        $count++;
                    }
                    $minData->where('id', $request->id)->update(['sorting' => $sorting]);

                    foreach ($maxData as $value) {
                        $sorting++;
                        $model->where('id', $value['id'])->update(['sorting' => $sorting]);
                    }
                }
            } else {
                $model->find($request->id)->update(['sorting' => $request->number]);
            }
        }

        return response()->json(true);
    }

    /**
     * Last Sorting your data.
     */
    public function lastSorting(Request $request)
    {
        if (! empty($request->model)) {
            /*-----MODLE DEFINE-----*/
            $explode = explode('-', $request->model);
            $implode = implode('\\', $explode);
            $model_name = '\\App\\Models\\'.$implode;
            $model = new $model_name;
        }
        if (! empty($model)) {
            return $model->count() + 1;
        }
    }
}
