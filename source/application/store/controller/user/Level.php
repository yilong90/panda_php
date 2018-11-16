<?php

namespace app\store\controller\user;

use app\store\controller\Controller;
use app\store\model\Level as LevelModel;

/**
 * 用户等级管理
 * Class User
 * @package app\store\controller
 */
class Level extends Controller
{
    /**
     * 用户等级列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new LevelModel();
        $list = $model::getAll();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 编辑用户等级
     * @param $level_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($level_id)
    {
        // 模板详情
        $model = LevelModel::get($level_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('level'))) {
            return $this->renderSuccess('更新成功', url('user.level/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }
}
