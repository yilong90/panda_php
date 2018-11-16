<?php

namespace app\common\model;

use think\Request;

/**
 * 级别模型类
 * Class User
 * @package app\common\model
 */
class Level extends BaseModel
{
    public function user()
    {
        return $this->hasMany('User', 'level_id');
    }
}