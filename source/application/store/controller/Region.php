<?php

namespace app\store\controller;

use app\common\model\Region as RegionModel;
/**
 * 地址控制器
 * Class Goods
 * @package app\store\controller
 */
class Region extends Controller
{
    public function get_region()
    {

        $cache = RegionModel::getCacheTree();
        if($pid = $this->request->param('province_id')) {
            if($cid = $this->request->param('city_id')) {
                foreach($cache[$pid]['city'][$cid]['region'] as $v) {
                    $res[] = ['id'=>$v['id'], 'name'=>$v['name']];
                }
            }
            foreach($cache[$pid]['city'] as $v) {
                $res[] = ['id'=>$v['id'], 'name'=>$v['name']];
            }
        } else {
            foreach($cache as $v) {
                $res[] = ['id'=>$v['id'], 'name'=>$v['name']];
            }
        }
        return $res;
    }
}