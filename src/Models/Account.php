<?php

namespace Luminee\Portal\Models;

use Luminee\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'portal_account';

    protected $fillable = ['user_id', 'type_id', 'nickname', 'avatar', 'is_available'];

    public function user()
    {
        return $this->belongsTo('Luminee\Portal\Models\User', 'user_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('Luminee\Portal\Models\Type', 'type_id', 'id');
    }

}