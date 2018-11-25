<?php

namespace app\store\model;

use app\common\model\Warehouse as WarehouseModel;

/**
 * 级别模型
 * Class Warehouse
 * @package app\store\model
 */
class Warehouse extends WarehouseModel
{
    public static function getAll()
    {
        $model = new static;
        return $model->select();
    }
}
