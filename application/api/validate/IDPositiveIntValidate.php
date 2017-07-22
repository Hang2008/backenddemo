<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 9:33 PM
 */

namespace app\api\validate;


class IDPositiveIntValidate extends BaseValidate {
    protected $rule = ['id' => 'require|isPositiveInteger'];
    protected $message = ['id' => 'id must be a positive integer'];

    public function validate() {
        parent::validate();
    }
}