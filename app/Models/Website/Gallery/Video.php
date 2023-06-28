<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\Website\Gallery;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getThumbnailAttribute($value)
    {
        return url('/').'/public/storage/'.$value;
    }
}
