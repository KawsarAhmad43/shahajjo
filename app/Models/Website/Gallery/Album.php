<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\Website\Gallery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d M Y H:i A',
        'updated_at' => 'datetime:d M Y  H:i A',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($url) {
            $url->slug = Album::createSlug($url->name);
        });
    }

    public static function createSlug($name)
    {
        $slug = Str::slug($name);
        $count = Album::where(['slug' => $slug])->count();
        if ($count > 0) {
            $slug = $slug.$count;
        }

        return $slug;
    }

    public function getImageAttribute($value)
    {
        if (! empty($value)) {
            return url('/').'/public/storage/'.$value;
        }

        return null;
    }
}
