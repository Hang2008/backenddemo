<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 5:20 PM
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception {
    //http 状态码 404, 200
    public $code = 400;
    public $message = 'General Error';
    public $errorCode = 10000;

    /**
     * BaseException constructor.
     * @param int $code
     * @param string $message
     * @param int $errorCode
     */
    public function __construct($params = []) {
        if (!is_array($params)) {
            return;
//            throw new Exception('param must be array');
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('message', $params)) {
            $this->message = $params['message'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}