<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Profile extends BaseModel
{
    protected $guarded = ['id'];

    protected $logName = 'Profile';

    public function getFileAttribute($value)
    {
        if (! empty($value)) {
            return url('').'/public/storage/'.$value;
        }

        return null;
    }

    public function getImageAttribute($value)
    {
        if (! empty($value)) {
            return url('').'/public/storage/'.$value;
        }

        return null;
    }

    public function getCorpAttribute($value)
    {
        if (! empty($value)) {
            return url('').'/public/storage/'.$value;
        }

        return null;
    }
}
