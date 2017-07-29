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
        $params = Request::instance()
                         ->param();
        $result = $this->batch()
                       ->check($params);
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

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '') {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            //指明字段$field
//            return $field . ' must be a positive integer';
            return false;
        }

    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '') {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    //每一个验证器都可以用来过滤参数
    public function getDataByRule($arrays) {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
//从客户端传来的参数不允许包含user_id或者uid,防止恶意复写user_id外键
            throw new ParameterException(['message' => 'Params contain user_id or uid is not allowed']);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}
