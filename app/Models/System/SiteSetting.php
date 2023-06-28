<?php
/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\System;

use App\Models\Base\BaseModel;

class SiteSetting extends BaseModel
{
    protected $guarded = ['id'];

    protected $logName = 'Site Settings';

    public function getLogoAttribute($value)
    {
        return ! empty($value)
            ? url('/').'/public/storage/'.$value
            : url('/').'/public/images/n-logo.png';
    }

    public function getLogoSmallAttribute($value)
    {
        return ! empty($value)
            ? url('/').'/public/storage/'.$value
            : url('/').'/public/images/n-logo.png';
    }

    public function getFaviconAttribute($value)
    {
        return ! empty($value)
            ? url('/').'/public/storage/'.$value
            : url('/').'/public/images/nogor-favicon.png';
    }
}
