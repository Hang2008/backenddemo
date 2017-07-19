<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 15/07/2017
 * Time: 11:00 PM
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {
    public function validate() {
        $params = Request::instance()->param();
        $result = $this->batch()->check($params);
        if (!$result) {
            $temp = '';
            if (is_array($this->error)) {
                foreach ($this->error as $msg) {
                    $temp = $temp . ";" . $msg;
                }
                $this->error = $temp;
            }
            $e = new ParameterException(["message" => $this->error]);
            throw $e;
        } else {
            return true;
        }
    }
}