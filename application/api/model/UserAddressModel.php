<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 29/07/2017
 * Time: 8:25 PM
 */

namespace app\api\model;


class UserAddressModel extends BaseModel {
    protected $table = 'user_address';
    protected $hidden = ['delete_time', 'update_time'];
}