<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 23/07/2017
 * Time: 10:03 PM
 */

namespace app\api\controller\v1;


use app\api\model\CategoryModel;
use app\lib\exception\CategoryNotFoundException;

class Category {
    public function getAllCategories() {
        //第一种写法
//        $result = CategoryModel::with('topicImg')->select();
        //第二种写法
        //查询全部用all也可以
        $result = CategoryModel::all([], 'topicImg');
        if ($result->isEmpty()) {
            throw new CategoryNotFoundException();
        }
        return $result;
    }
}