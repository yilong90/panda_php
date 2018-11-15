<?php

namespace app\common\model;

use think\Request;

/**
 * 用户模型类
 * Class User
 * @package app\common\model
 */
class User extends BaseModel
{
    protected $name = 'user';

    // 性别
    private $gender = ['未知', '男', '女'];
    /**
     * 关联收货地址表
     * @return \think\model\relation\HasMany
     */
    public function address()
    {
        return $this->hasMany('UserAddress');
    }

    /**
     * 关联收货地址表 (默认地址)
     * @return \think\model\relation\BelongsTo
     */
    public function addressDefault()
    {
        return $this->belongsTo('UserAddress', 'address_id');
    }

    public function level()
    {
        return $this->belongsTo('Level', 'level_id');
    }

    public function invitedUser()
    {
        return $this->hasOne('User')->field('user_id,nickName');
    }

    /**
     * 显示性别
     * @param $value
     * @return mixed
     */
    public function getGenderAttr($value)
    {
        return $this->gender[$value];
    }

    /**
     * 获取用户列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        $request = Request::instance();
        return $this->order(['create_time' => 'desc'])
            ->paginate(15, false, ['query' => $request->request()]);
    }



    public function getTeamMember($user_id)
    {
        return $this->where('user_id', '=', $user_id)->field('user_id,nickName,phone_number,avatarUrl')->select();
    }

    /**
     * 获取用户信息
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return self::get($where, ['level', 'invitedUser', 'addressDefault', 'address']);
    }
}
