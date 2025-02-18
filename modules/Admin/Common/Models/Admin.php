<?php

/**
 * Author: wtySk
 * Time: 13/11/2018  13:36
 */

namespace Modules\Admin\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    const DELETED_AT = 'deleted_at';

    protected $table = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * 判断用户是否存在
     *
     * @return mixed
     */
    public function scopeExist(): mixed
    {
        return $this->where('deleted_at', null);
    }
}
