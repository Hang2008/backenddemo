<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 23/07/2017
 * Time: 3:50 PM
 */

namespace app\api\controller\v1;


use app\api\model\ProductModel;
use app\api\validate\Count;

class Product {
    public function getRecentProduct($count = 15) {
        (new Count())->validate();
        $result = ProductModel::getRecents($count);
        return $result;
    }
}