<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 31/07/2017
 * Time: 5:44 PM
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderValidate extends BaseValidate {
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $subRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($value) {
        if (empty($value)){
            throw new ParameterException([
                'message' => 'Products list should not be empty'
            ]);
        }
        if (is_array($value)){
            throw new ParameterException([
                'message' => 'Products list should be an array'
            ]);
        }
        foreach ($value as $item){
            $this->checkProductList($item);
        }
    }

    protected function checkProductList($value){
        $validate= new BaseValidate($this->subRule);
        $result = $validate->validate($value);
        if (!$result){
            throw new ParameterException([
                'message' => "Product list item params error"
            ]);
        }
    }
}