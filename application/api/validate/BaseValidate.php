<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 11:00 PM
 */

namespace app\api\validate;


use think\Exception;
use think\Validate;
use think\Request;

class BaseValidate extends Validate {
    public function validate() {
        $params = Request::instance()->param();
        $result = $this->check($params);
        if (!$result) {
            $error = $this->error;
            throw new Exception($error);
        }
        return true;
    }
}