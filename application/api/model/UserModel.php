<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 2:01 PM
 */

namespace app\api\model;


class UserModel extends BaseModel {
    protected $table = 'user';
    protected $hidden = ['delete_time', 'update_time'];

    public function address() {
        //在没有外键的一方定义一对一关系用hasone
        //拥有外键的一方定义一对一关系用belongsto
        //我写的
//        return self::hasOne('UserAddressModel', 'user_id', 'id')
//                   ->where('user_id', '=', $id)
//                   ->find();
        //老师写的,为什么不找呢?
        $result = $this->hasOne('UserAddressModel', 'user_id', 'id');
        return $result;
    }

    public static function getUserByOpenID($openid) {
        $user = self::where('openid', '=', $openid)
                    ->find();
        return $user;
    }
}