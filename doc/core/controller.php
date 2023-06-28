<?php

use App\Http\Controllers\Controller;
use Exception;

// Image upload.
class YourController extends Controller
{
    /**
     * Short Query
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        $query = YourModel::latest();
        $query->whereAny('status', $request->status);

        $query->whereLike($request->field_name, $request->value);

        $query->whereSub('relational_table', 'field_name', $request->value);

        $query->whereSubLike('relational_table', 'field_name', $request->value);

        $query->whereDates('created_at', $request->from_date, $request->to_date);

        $datas = $query->paginate($request->pagination);

        return new Resource($datas);
    }

    /**
     * Store Image
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function storeImage(Request $request)
    {
        // Without Cropping Image
        $file = $request->file('image');
        if (! empty($file)) {
            $data['image'] = $this->upload($file, 'folder_name');
        }

        // With Cropping Image base 64
        if (! empty($request->image)) {
            $data['image'] = $this->upload($request->image, 'folder_name', null, true);
        }
    }

    /**
     * Update Image
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateImage(Request $request, YourModel $yourModel)
    {
        // Without Cropping Image
        $file = $request->file('image');
        if (! empty($file)) {
            $data['image'] = $this->upload($file, 'folder_name', $yourModel->image);
        } else {
            $data['image'] = $this->oldFile($yourModel->image);
        }

        // With Cropping Image base 64
        if (! empty($request->image) && $request->image != $yourModel->image) {
            $data['image'] = $this->upload($request->image, 'folder_name', $yourModel->image, true);
        } else {
            $data['image'] = $this->oldFile($yourModel->image);
        }
    }

    /**
     * try catch
     *
     * use Exception;
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validateCheck($request)) {
            try {
                YourModel::create($request->all());
            } catch (Exception $ex) {
                return response()->json(['exception' => $ex->errorInfo ?? $ex->getMessage()], 422);
            }
        }
    }

    /**
     * Validate form field.
     *
     * @return \Illuminate\Http\Response
     */
    public function validateCheck($request, $model = null)
    {
        return $request->validate([
            'name' => 'required|string|max:55|unique:users,name,'.$model->id,
            'unique' => 'required|unique:users', //unique coloum
            'name' => 'required|string|min:0|max:191',
            'email' => 'required|email|date|string|min:0|max:191',
            'mobile' => 'required|integer|string|min:0|max:191',
            'date' => 'nullable|date|string',

            // Validate that an uploaded file is exactly 512 kilobytes...
            'image' => 'mimes:jpg,png,pdf|file|size:512',

            // Validate that a string is exactly 12 characters long...
            'title' => 'size:12',

        ], [
            'image' => 'Image must be jpg, png, pdf',
        ]);
    }
}
