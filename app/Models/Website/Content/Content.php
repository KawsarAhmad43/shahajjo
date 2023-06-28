<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\Website\Content;

use App\Models\Base\BaseModel;
use Illuminate\Support\Str;

class Content extends BaseModel
{
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($url) {
    //         $url->slug = Content::createSlug($url->title);
    //     });
    // }
    // private static function createSlug($name)
    // {
    //     $slug  = Str::slug($name);
    //     $count = Content::where(['slug' => $slug])->count();
    //     if ($count > 0) {
    //         $slug = $slug . $count;
    //     }
    //     return $slug;
    // }

    public function contentFiles()
    {
        return $this->hasMany(ContentFile::class)->oldest('sorting');
    }

    public function getImageAttribute($value)
    {
        if (! empty($value)) {
            return url('/').'/public/storage/'.$value;
        }

        return null;
    }

    public function setIsMetaAttribute($value)
    {
        $this->attributes['is_meta'] = $value == true ? 1 : 0;
    }

    public function getIsMetaAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function setMetaTagAttribute($value)
    {
        $this->attributes['meta_tag'] = json_encode($value);
    }

    public function getMetaTagAttribute($value)
    {
        $tag = json_decode($value);

        return explode(',', $tag);
    }
}
