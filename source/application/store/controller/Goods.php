<?php

namespace app\store\controller;

use app\common\model\GoodsPrice;
use app\store\model\GoodsSpec;
use app\store\model\Level;
use app\store\model\Warehouse;
use app\store\model\Category;
use app\store\model\Delivery;
use app\store\model\Goods as GoodsModel;

/**
 * 商品管理控制器
 * Class Goods
 * @package app\store\controller
 */
class Goods extends Controller
{
    /**
     * 商品列表(出售中)
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new GoodsModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加商品
     * @return array|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            // 配送模板
            $delivery = Delivery::getAll();
            $levels = Level::getAll();
            $warehouse = Warehouse::getAll();
            return $this->fetch('add', compact('catgory', 'delivery', 'levels', 'warehouse'));
        }
        $model = new GoodsModel;
        if ($model->add($this->postData('goods'))) {
            return $this->renderSuccess('添加成功', url('goods/index'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }

    /**
     * 删除商品
     * @param $goods_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($goods_id)
    {
        $model = GoodsModel::get($goods_id);
        if (!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 商品编辑
     * @param $goods_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($goods_id)
    {
        // 商品详情
        $model = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            // 配送模板
            $delivery = Delivery::getAll();
            // 多规格信息
            $specData = 'null';
            $prices = 'null';

            $warehouse = Warehouse::getAll();
            if ($model['spec_type'] == 20) {
                $specData = json_encode($model->getManySpecData($model['spec_rel'], $model['spec']));
            }elseif($model['spec_type'] == 10) {
                $resGoodsSpec = GoodsSpec::get(['goods_id' => $goods_id]);
                $prices = GoodsPrice::all(['goods_spec_id'=>$resGoodsSpec['goods_spec_id']]);
            }
            $levels = Level::getAll();
            return $this->fetch('edit', compact('model', 'catgory', 'delivery', 'specData', 'levels', 'prices', 'warehouse'));

        }
        // 更新记录
        if ($model->edit($this->postData('goods'))) {
            return $this->renderSuccess('更新成功', url('goods/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }

}
