<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 13/08/2017
 * Time: 4:25 PM
 */

namespace app\api\validate;


class PageParamsValidate extends BaseValidate {
    protected $rule = ['page' => 'isPositiveInteger', 'size' => 'isPositiveInteger'];
    protected $message = ['page' => '分页参数必须是正整数', 'size' => '分页参数必须是正整数'];
}