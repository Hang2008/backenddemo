<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 05/09/2017
 * Time: 4:21 PM
 */

namespace app\api\model;


class ThirdAppModel extends BaseModel {
    public static function check($ac, $se)
    {
        $app = self::where('app_id','=',$ac)
                   ->where('app_secret', '=',$se)
                   ->find();
        return $app;

    }
}