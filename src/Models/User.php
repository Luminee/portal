<?php

namespace Luminee\User\Models;

use Luminee\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'user';

    protected $fillable = ['username', 'email', 'phone', 'password', 'is_available'];

    public function accountList()
    {
        return $this->hasMany('Luminee\User\Models\Account', 'user_id', 'id');
    }
}