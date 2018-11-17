<?php

namespace app\store\controller\setting;

use app\store\controller\Controller;
use app\store\model\StoreUser as StoreUserModel;

/**
 * 商户管理员控制器
 * Class StoreUser
 * @package app\store\controller
 */
class User extends Controller
{

    public function index()
    {
        $model = new StoreUserModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 删除用户
     * @param $store_user_id
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function delete($store_user_id)
    {
        $model = StoreUserModel::detail($store_user_id);

        if($model['user_name'] == 'admin') {
            $error =  '该用户不允许被删除';
            return $this->renderError($error);
        }

        if (!$model->remove()) {
            $error = $model->getError() ?: '删除失败';
            return $this->renderError($error);
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 添加用户
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        // 新增记录
        $model = new StoreUserModel;
        if ($model->add($this->postData('user'))) {
            return $this->renderSuccess('添加成功', url('setting.user/index'));
        }
        $error = $model->getError() ?: '添加失败';
        return $this->renderError($error);
    }
}
