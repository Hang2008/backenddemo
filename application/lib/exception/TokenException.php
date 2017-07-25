<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 25/07/2017
 * Time: 3:56 PM
 */

namespace app\lib\exception;


class TokenException extends BaseException {
    public $code = 400;
    public $message = 'Token Exception';
    public $errorCode = 10000;
}