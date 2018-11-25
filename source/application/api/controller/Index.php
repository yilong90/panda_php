<?php

namespace app\api\controller;

use app\api\model\WxappPage;
use app\api\model\Goods as GoodsModel;

/**
 * 首页控制器
 * Class Index
 * @package app\api\controller
 */
class Index extends Controller
{
    /**
     * 首页diy数据
     * @return array
     * @throws \think\exception\DbException
     */
    public function page()
    {
        $user_info = $this->getUser();
        $level_id = $user_info['level_id'];
        // 页面元素
        $wxappPage = WxappPage::detail();
        $items = $wxappPage['page_data']['array']['items'];
        // 新品推荐
        $model = new GoodsModel;
        $newest = $model->getNewList($level_id);
        // 猜您喜欢
        $best = $model->getBestList($level_id);
        return $this->renderSuccess(compact('items', 'newest', 'best'));
    }

}
