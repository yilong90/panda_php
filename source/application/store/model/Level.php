<?php

namespace app\store\model;

use app\common\model\Level as LevelModel;

/**
 * 级别模型
 * Class User
 * @package app\store\model
 */
class Level extends LevelModel
{
    public static function getAll()
    {
        $model = new static;
        return $model->select();
    }
}
