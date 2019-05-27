<?php

namespace Luminee\Portal\Models;

use Luminee\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'portal_user';

    protected $fillable = ['username', 'email', 'phone', 'password', 'is_available'];

    protected $hidden = ['password'];

    public function accountList()
    {
        return $this->hasMany('Luminee\Portal\Models\Account', 'user_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }

}