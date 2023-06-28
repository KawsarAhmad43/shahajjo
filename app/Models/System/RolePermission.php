<?php

/**
 * @Nogor Solutions Ltd
 */

namespace App\Models\System;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Auth;

class RolePermission extends BaseModel
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $logName = 'Role Permission';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public static function permissions()
    {
        return RolePermission::select('permission_id', 'role_id')
            ->with(['permission' => function ($q) {
                $q->select('id', 'name', 'route', 'parent_id');
            }])->get()->groupBy('role_id');
    }

    public static function permissionProcess($obj)
    {
        $routes = [];
        $rolePermissions = $obj->get(Auth::guard('admin')->user()->role_id);
        if ($rolePermissions) {
            foreach ($rolePermissions->toArray() as $value) {
                if (! empty($value['permission']['parent_id'])) {
                    $routes[] = $value['permission']['route'];
                }

            }
        }

        return $routes;
    }
}
