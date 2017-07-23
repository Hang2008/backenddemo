<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 23/07/2017
 * Time: 3:58 PM
 */

namespace app\api\validate;


class Count extends BaseValidate {
    protected $rule = ['count' => 'isPositiveInteger|between:1,15'];
}