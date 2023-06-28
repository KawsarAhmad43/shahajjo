<?php

use App\Models\Base\BaseModel;
use App\Models\Base\ParentModel;

class YourModel extends BaseModel
{
    // use App\Models\Base\BaseModel;
    // If you use this BaseModel in your model you can access this

    /**
     * For query
     *
     * @return $query->active()->get(); // status == 'active'
     * @return $query->pending()->get(); // status == 'pending'
     */

    /**
     * Store Activity Log
     */
}

// Parent model.
class Model2 extends ParentModel
{
    // use App\Models\Base\ParentModel;

    // If you use this BaseModel in your model you can access this

    /**
     * For query
     *
     * @return $query->active()->get(); // status == 'active'
     * @return $query->pending()->get(); // status == 'pending'
     */

    /**
     * Store Activity Log
     */

    /**
     * Store created_by, created_ip, updated_by, updated_ip
     * Please put in your database table this four column
     */
}

// Using attributes.
class Attributes extends BaseModel
{
    /**
     *  @return  column_name: from_date = FromDate / date = Date
     */
    public function setFromDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

    public function getImageAttribute($value)
    {
        if (! empty($value)) {
            return url('/').'/public/storage/'.$value;
        }

        return null;
    }
}

// For slug.
class Slug extends BaseModel
{
    /**
     * use Illuminate\Support\Str;
     *
     *  @return slug create when data store
     */

    // use this in your model, if you create slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = ModelName::createSlug($url->title);
        });
    }

    private static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = ModelName::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug.$count;
        }

        return $slug;
    }
}
