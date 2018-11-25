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

    /**
     * 关联级别表
     * @return \think\model\relation\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo('Level', 'level_id');
    }

    /**
    * 关联自身
    * @return \think\model\relation\BelongsTo
    */
    public function invitedUser()
    {
        return $this->belongsTo('User', 'invited_by');
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
        if($search = trim($request->param('search'))) {
            return $this->where('nickName like :nickName OR phone_number = :phone_number ',
                ['nickName'=>"%{$search}%", 'phone_number'=>$search])->select();
        }
        return $this->order(['create_time' => 'desc'])
            ->paginate(15, false, ['query' => $request->request()]);
    }

    public function getMember($user_id)
    {
        return $this->where("path like (select concat(path,',',user_id,'%') as path from panda_user where user_id= :user_id)",
            ['user_id'=>$user_id])->select();
    }

    /**
     * 获取用户信息
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return self::get($where, 'level');
    }
}
