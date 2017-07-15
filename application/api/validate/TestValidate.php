<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 8:09 PM
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate {
    protected $rule = ['name' => 'require|max:10', 'email' => 'email'];

}