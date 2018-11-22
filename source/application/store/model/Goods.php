<?php

namespace app\store\model;

use app\common\model\Goods as GoodsModel;
use think\Db;

/**
 * 商品模型
 * Class Goods
 * @package app\store\model
 */
class Goods extends GoodsModel
{
    /**
     * 添加商品
     * @param array $data
     * @return bool
     */
    public function add(array $data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['spec']['wxapp_id'] = self::$wxapp_id;
//         开启事务
        Db::startTrans();
        try {
            // 添加商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->addGoodsSpec($data);
            // 商品图片
            $this->addGoodsImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
        }
        return false;
    }

    private function addGoodsPrice($goods_spec, $price) {
        $model = new GoodsPrice();
        for($i=0; $i<count($goods_spec); $i++) {
            $data = [];
            foreach($price[$i] as $v) {
               $v['goods_spec_id'] = $goods_spec[$i]['goods_spec_id'];
               $data[] = $v;
            }
            $model->saveAll($data);
        }
    }

    /**
     * 添加商品图片
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addGoodsImages($images)
    {
        $this->image()->delete();
        $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }, $images);
        return $this->image()->saveAll($data);
    }

    /**
     * 编辑商品
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['spec']['wxapp_id'] = self::$wxapp_id;
        // 开启事务
        Db::startTrans();
        try {
            // 保存商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->addGoodsSpec($data, true);
            // 商品图片
            $this->addGoodsImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 添加商品规格
     * @param $data
     * @param $isUpdate
     * @throws \Exception
     */
    private function addGoodsSpec(&$data, $isUpdate = false)
    {
        // 更新模式: 先删除所有规格
        $model = new GoodsSpec;
        $isUpdate && $model->removeAll($this['goods_id']);
        // 添加规格数据
        if ($data['spec_type'] == '10') {
            $every_price = [];
            if(isset($data['spec']['goods_price'])) {
                $data_price = $data['spec']['goods_price'];
                unset($data['spec']['goods_price']);
            }
            // 单规格
            $res = $this->spec()->save($data['spec']);
            foreach($data_price as $k=>$p) {
                $every_price[] = [
                    'level_id'=>$k,
                    'goods_price'=> $p,
                    'wxapp_id' => self::$wxapp_id,
                    'goods_spec_id' => $res['goods_spec_id']
                ];
            }
            if(isset($data['spec']['goods_price']))
                unset($data['spec']['goods_price']);
            // 价格
            $goodsPriceModel = new \app\common\model\GoodsPrice();
            $goodsPriceModel->saveAll($every_price);
        } else if ($data['spec_type'] == '20') {
            $price = [];
            if(isset($data['spec']['goods_price']))
                unset($data['spec']['goods_price']);
            $levels = Level::getAll();
            foreach($data['spec_many']['spec_list'] as &$v) {
                $every_price = [];
                if(isset($v['form']['goods_price']))
                    unset($v['form']['goods_price']);
                foreach($levels as $level) {
                    $every_price[] = [
                        'level_id'=>$level['level_id'],
                        'goods_price'=> $v['form']['price' . $level['level_id']],
                        'wxapp_id' => self::$wxapp_id
                    ];
                    if(isset($v['form']['price' . $level['level_id']]))
                        unset($v['form']['price' . $level['level_id']]);
                }
                $price[] = $every_price;
            }
            // 添加商品与规格关系记录
            $model->addGoodsSpecRel($this['goods_id'], $data['spec_many']['spec_attr']);
            // 添加商品sku
            $res = $model->addSkuList($this['goods_id'], $data['spec_many']['spec_list']);
            $this->addGoodsPrice($res, $price);
        }
    }

    /**
     * 删除商品
     * @return bool
     */
    public function remove()
    {
        // 开启事务处理
        Db::startTrans();
        try {
            // 删除商品sku
            (new GoodsSpec)->removeAll($this['goods_id']);
            // 删除商品图片
            $this->image()->delete();
            // 删除当前商品
            $this->delete();
            // 事务提交
            Db::commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Db::rollback();
            return false;
        }
    }

}
