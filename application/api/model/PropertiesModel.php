<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 27/07/2017
 * Time: 9:22 PM
 */

namespace app\api\model;


class PropertiesModel extends BaseModel {
    protected $table = 'product_property';
    protected $hidden = ['delete_time', 'update_time', 'product_id', 'id'];
}