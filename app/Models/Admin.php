<?php

namespace App\Models;

use App\Models\System\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role_id',
        'profile',
        'mobile',
        'address',
        'block',
        'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id')->select('id', 'name');
    }

    public function getProfileAttribute($value)
    {
        return (! empty($value)) ?
            url('/').'/public/storage/'.$value : url('/').'/public/images/profile.jpg';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
