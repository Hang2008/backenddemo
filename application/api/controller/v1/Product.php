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
use app\api\validate\IDPositiveIntValidate;
use app\lib\exception\ProductNotFoundException;

class Product {
    public function getRecentProduct($count = 15) {
        (new Count())->validate();
        $result = ProductModel::getRecents($count);
        if ($result->isEmpty()) {
            throw new ProductNotFoundException();
        }
        //转化成collection对象来临时隐藏不需要的 字段, 避免在根模型中同意修改
        //为了方便所以设置config让模型子返回数据集
//        $result = collection($result)->hidden(['summary']);
        return $result->hidden(['summary']);
    }

    public function getByCategory($id = '') {
        (new IDPositiveIntValidate())->validate();
        $results = ProductModel::getByCategory($id);
        if ($results->isEmpty()) {
            throw new ProductNotFoundException();
        }
        return $results->hidden(['summary']);
    }

    public function getOneById($id = '') {
        (new IDPositiveIntValidate())->validate();
        $results = ProductModel::getDetailById($id);
        if (!$results) {
            throw new ProductNotFoundException();
        }
        return $results->hidden(['summary']);
    }
}