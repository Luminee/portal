<?php

namespace Luminee\Portal\Models;

use Luminee\Base\Models\BaseModel;

class Type extends BaseModel
{
    protected $table = 'portal_account_type';

    protected $fillable = ['name', 'code'];
    
}