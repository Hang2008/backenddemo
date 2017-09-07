<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 05/09/2017
 * Time: 4:13 PM
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate {
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];
}