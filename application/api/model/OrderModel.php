<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 02/08/2017
 * Time: 10:24 PM
 */

namespace app\api\model;


class OrderModel extends BaseModel {
    protected $table = 'order';
    protected $hidden = ['delete_time', 'update_time', 'user_id'];
    protected $autoWriteTimestamp = true;
}