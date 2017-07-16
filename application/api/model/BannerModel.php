<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 3:53 PM
 */

namespace app\api\model;


use think\Exception;

class BannerModel {
    public static function getBannerByID($id) {
        try {
            1 / 0;
        } catch (Exception $exception) {
            throw $exception;
        }
        return 'this is banner info';
    }
}