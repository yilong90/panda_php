<?php

namespace app\store\controller;

use app\common\model\UserAddress;
use app\store\model\User as UserModel;
use app\store\model\Level as LevelModel;
use app\store\model\UserAddress as UserAddressModel;

/**
 * 用户管理
 * Class User
 * @package app\store\controller
 */
class User extends Controller
{
    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new UserModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 用户详情
     * @param $user_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function detail($user_id)
    {
        // 用户详情
        $model = UserModel::detail($user_id);
        $invited_user = $model->invitedUser->nickName;
        $levels = LevelModel::getAll();
        $addresses = [];
        foreach($model->address as $v) {
            $addresses[] = UserAddress::detail($user_id, $v->address_id);
        }
        return $this->fetch('detail', compact('model', 'invited_user', 'levels', 'addresses'));
    }
}
