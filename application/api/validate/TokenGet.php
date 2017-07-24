<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 24/07/2017
 * Time: 1:44 PM
 */

namespace app\api\validate;


class TokenGet extends BaseValidate {
    protected $rule = ['code' => 'require|isNotEmpty'];
    protected $message = ['code' => 'code is invalid'];
}