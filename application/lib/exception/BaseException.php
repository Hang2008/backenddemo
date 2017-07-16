<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 16/07/2017
 * Time: 5:20 PM
 */

namespace app\lib\exception;


class BaseException {
    //http 状态码 404, 200
    public $code = 400;
    public $message = 'Invalide Params';
    public $errorCode = 10000;
}