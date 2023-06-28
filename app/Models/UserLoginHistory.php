<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models;

use App\Models\Base\BaseModel;

class UserLoginHistory extends BaseModel
{
    protected $guarded = ['id'];

    protected $logName = 'UserLoginHistory';

    protected $table = 'user_login_histories';

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
