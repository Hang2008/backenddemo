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

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '') {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            //指明字段$field
            return $field . ' must be a positive integer';
        }
    }

    public function validate() {
        parent::validate();
    }
}