<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\Website\Gallery;

use App\Models\SliderDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Slider extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d M Y H:i A',
        'updated_at' => 'datetime:d M Y  H:i A',
    ];

    /**@Guard */
    protected $guarded = [];

    const HEADER = 'header';

    public function scopeHeader($query)
    {
        return $query->where('position', 'header');
    }

    public function getSliderAttribute($value)
    {
        if (! empty($value)) {
            return url('/').'/public/storage/'.$value;
        }

        return null;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($req) {
            $req->slug = Slider::createSlug($req->title);
        });
    }

    public static function createSlug($title)
    {
        $slug = Str::slug($title);
        $count = Slider::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug.'-'.$count.time();
        }

        return $slug;
    }

    public function details()
    {
        return $this->hasMany(SliderDetails::class, 'slider_id', 'id');
    }
}
