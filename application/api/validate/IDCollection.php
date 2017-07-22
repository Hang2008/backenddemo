<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 22/07/2017
 * Time: 9:17 PM
 */

namespace app\api\validate;


class IDCollection extends BaseValidate {
    protected $rule = ['ids' => 'require|isCollectionOK'];
    protected $message = ['ids' => 'each of the ids must be positive integer'];

    protected function isCollectionOK($value) {
        $mArray = explode(',', $value);
        if (empty($mArray)) {
            return false;
        }
        foreach ($mArray as $id) {
            if (!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }
}