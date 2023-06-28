<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class Category extends BaseModel
{
    protected $guarded = ['id'];

    protected $logName = 'Category';
}
