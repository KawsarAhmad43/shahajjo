<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\System;

use App\Models\Base\BaseModel;

class Permission extends BaseModel
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $logName = 'Permission';

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
}
