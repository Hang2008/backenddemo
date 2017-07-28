<?php
/**
 * Created by PhpStorm.
 * User: lihang
 * Date: 25/07/2017
 * Time: 3:56 PM
 */

namespace app\lib\exception;


class TokenException extends BaseException {
    public $code = 401;
    public $message = 'Token has expired or been invalid';
    public $errorCode = 10000;
}