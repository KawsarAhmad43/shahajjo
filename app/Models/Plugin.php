<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class Plugin extends BaseModel
{
    protected $guarded = ['id'];

    protected $logName = 'Plugin';

    public function getZipFileAttribute($value)
    {
        if (! empty($value)) {
            return url('').'/public/storage/'.$value;
        }

        return null;
    }
}
