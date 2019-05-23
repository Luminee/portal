<?php

namespace Luminee\User\Models;

use Luminee\Base\Models\BaseModel;

class Type extends BaseModel
{
    protected $table = 'user_account_type';

    protected $fillable = ['name', 'code'];
    
}