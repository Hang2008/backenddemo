<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 3:53 PM
 */

namespace app\api\model;


use think\Db;

class BannerModel {
    public static function getBannerByID($id) {
        $result = Db::query('select * from banner_item where banner_id=?', [$id]);
        return $result;
    }
}