<?php

namespace app\store\model;

use app\common\model\User as UserModel;

/**
 * 用户模型
 * Class User
 * @package app\store\model
 */
class User extends UserModel
{
    /**
     * 编辑用户
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        return $this->allowField(['level_id'])->save($data);
    }
}
