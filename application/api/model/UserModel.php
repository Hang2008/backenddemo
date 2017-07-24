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

    public static function getUserByOpenID($openid) {
        $user = self::where('openid', '=', $openid)->find();
        if ($user) {

        } else {

        }
        return '';
    }
}